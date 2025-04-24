<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\models\BranchOffer;
use app\models\MealOffers;
use app\models\Offer;
use app\models\Reservation;
use app\models\Order;
use app\models\User;
use app\models\Payment;

class PaymentController extends Controller
{
    // Method to get payment data
    public function getPaymentData()
    {
        if (Application::$app->user) {
            try 
            {
                $branch_id = Application::$app->user->branch_id;

                if (!$branch_id) {
                    throw new \Exception("Branch ID is missing for the logged-in user.");
                }
                
                $payments = Payment::findPaymentsByBranch($branch_id);
                echo json_encode($payments);
            }
            catch (\Exception $e) 
            {
                // Log the error and return a proper JSON response
                error_log("Error fetching payment data: " . $e->getMessage());
                http_response_code(500); // Set HTTP status code to 500
                echo json_encode(['error' => 'Failed to fetch payment data', 'details' => $e->getMessage()]);
            }
        }
        else {
            http_response_code(401); // Set HTTP status code to 401 (Unauthorized)
            echo json_encode(['error' => 'No user is logged in']);
        }
    }

    public function updatePaymentStatus()
    {
        $requestBody = json_decode(file_get_contents("php://input"), true);

        if (!isset($requestBody['payment_id'], $requestBody['payment_status'])) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Invalid input data']);
            return;
        }

        $paymentId = $requestBody['payment_id'];
        $newStatus = $requestBody['payment_status'];
        $paymentType = $requestBody['payment_type'] ?? null; // Optional field

        try {
            // Find the payment by ID
            $payment = Payment::findOneOriginal(['payment_id' => $paymentId]);

            if (!$payment) {
                http_response_code(404); // Not Found
                echo json_encode(['error' => 'Payment not found']);
                return;
            }

            // Retrieve the reservation number associated with the payment
            $reservationNo = Payment::getReservationNoByPaymentId($paymentId);

            if (!$reservationNo) {
                http_response_code(404); // Not Found
                echo json_encode(['error' => 'Reservation not found for the payment']);
                return;
            }

            // Update all payments
            $updateResult = Payment::updatePaymentsByReservation($reservationNo, $newStatus, $paymentType);

            if ($updateResult) {
                http_response_code(200); // OK
                echo json_encode(['success' => 'Payment status updated successfully']);
            } else {
                http_response_code(500); // Internal Server Error
                echo json_encode(['error' => 'Failed to update payment status']);
            }
        } catch (\Exception $e) {
            error_log("Error updating payment status: " . $e->getMessage());
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => 'An error occurred', 'details' => $e->getMessage()]);
        }
    }

    public function getCardPayments()
    {
        $reservationId = $_GET['reservationId'] ?? null;

        if (!$reservationId) {
            error_log("Reservation ID is missing");
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Reservation ID is missing']);
            return;
        }

        try {
            $payments = Payment::findCardPayments(['reservation_no' => $reservationId]);

         

            if (!$payments) {
                http_response_code(404); // Not Found
                echo json_encode(['error' => 'No orders found for the reservation']);
                return;
            }
        
            // Calculate total amount and prepare item details
            $totalAmount = 0;
            $items = [];
            foreach ($payments as $payment) {
                $totalAmount += $payment['meal_price']*$payment['quantity'] ?? 0;
                $items[] = [
                    'meal_name' => $payment['meal_name'] ?? 'Unknown Meal',
                    'quantity' => $payment['quantity'] ?? 0,
                ];
            }

            // Get logged-in user details
            $user = Application::$app->user;

            if (!$user) {
                http_response_code(401);
                echo json_encode(['error' => 'User not logged in']);
                return;
            }
            
            $merchant_id = '1229387';
            $merchant_secret = 'MjY1MjE1MTEzNTUxOTQ0MzEwMTg5ODU5NzI4MTMzMTUxMTczMDM=';

            // Prepare data for PayHere
            $data = [
                'merchant_id' => $merchant_id,
                'return_url' => 'http://localhost:8080/payment/success',
                'cancel_url' => 'http://localhost:8080/payment/cancel',
                'notify_url' => 'http://localhost:8080/payment/notify',
                'order_id' => $payment['order_id'],
                'items' => $items,
                'amount' => number_format($totalAmount, 2, '.', ''),
                'currency' => 'LKR',
                'first_name' => $user->firstname,
                'last_name' => $user->lastname,
                'email' => $user->email,
                'phone' => $user->mobile_number,
                'address' => $user->address,
                'city' => 'Colombo',
                'country' => 'Sri Lanka',
            ];

            // Generate the hash
            $data['hash'] = strtoupper(md5(
                $merchant_id . $data['order_id'] . $data['amount'] . $data['currency'] . strtoupper(md5($merchant_secret))
            ));

            echo json_encode($data);
        } catch (\Exception $e) {
            error_log("Error fetching order details: " . $e->getMessage());
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => 'Failed to fetch order details', 'details' => $e->getMessage()]);
        }
    }

    public function handleNotify(){

        $postData = $_POST;

        $merchant_secret = "MjY1MjE1MTEzNTUxOTQ0MzEwMTg5ODU5NzI4MTMzMTUxMTczMDM="; // Replace with your Merchant Secret
        $localHash = strtoupper(md5(
            $postData['merchant_id'] . $postData['order_id'] . $postData['payhere_amount'] . $postData['payhere_currency'] . $postData['status_code'] . strtoupper(md5($merchant_secret))
        ));

        if ($localHash === $postData['md5sig'] && $postData['status_code'] == 2) {
            // Payment successful
            $orderId = $postData['order_id'];
            $payment = Payment::findOneOriginal(['order_id' => $orderId]);

            if ($payment) {
                $payment->payment_status = 'Completed';
                $payment->update();
            }

            http_response_code(200); // OK
            echo "Payment verified successfully";
        } else {
            http_response_code(400); // Bad Request
            echo "Payment verification failed";
        }
    }

    public function handleReturn()
    {
        header("Location: /");
        exit;
    }

    public function handleCancel()
    {
        echo "Payment was canceled. Redirect the user to a cancellation page.";
    }

    public function getCashPayments(){
        $reservationId = $_GET['reservationId'] ?? null;

        if (!$reservationId) {
            error_log("Reservation ID is missing");
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Reservation ID is missing']);
            return;
        }

        try {
            $payments = Payment::findCashPayments(['reservation_no' => $reservationId]);
            if (!$payments) {
                http_response_code(404); // Not Found
                echo json_encode(['error' => 'No orders found for the reservation']);
                return;
            }
            
            // Get the first payment ID
            $paymentId = $payments[0]['payment_id'] ?? null;

            if (!$paymentId) {
                http_response_code(404); // Not Found
                echo json_encode(['error' => 'No valid payment ID found']);
                return;
            }

            http_response_code(200); // OK
            echo json_encode(['payment_id' => $paymentId]);
        } catch (\Exception $e) {
            error_log("Error fetching order details: " . $e->getMessage());
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => 'Failed to fetch order details', 'details' => $e->getMessage()]);
        }

    }
    
  }