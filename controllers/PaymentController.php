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

    public function updatePaymentStatus(){

        $requestBody = json_decode(file_get_contents("php://input"), true);

        if (!isset($requestBody['payment_id'], $requestBody['payment_status'])) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Invalid input data']);
            return;
        }

        $paymentId = $requestBody['payment_id'];
        $newStatus = $requestBody['payment_status'];

        try {
            // Find the payment by ID
            $payment = Payment::findOneOriginal(['payment_id' => $paymentId]);

            if (!$payment) {
                http_response_code(404); // Not Found
                echo json_encode(['error' => 'Payment not found']);
                return;
            }

            // Update the payment status
            $payment->payment_status = $newStatus;

            if ($payment->update()) {
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

    public function initiatePayment(){

        try {
            $requestBody = json_decode(file_get_contents("php://input"), true);

            if (!isset($requestBody['order_id'], $requestBody['items'], $requestBody['amount'])) {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'Invalid input data']);
                return;
            }

            $merchant_id = "1229387";
            $merchant_secret = "MjY1MjE1MTEzNTUxOTQ0MzEwMTg5ODU5NzI4MTMzMTUxMTczMDM=";
            $loggedInUser = Application::$app->user;

            if (!$loggedInUser) {
                http_response_code(500); // Internal Server Error
                echo json_encode(['error' => 'User data is missing or invalid']);
                return;
            }
            $data = [
                'merchant_id' => $merchant_id,
                'return_url' => 'http://localhost/payment/success',
                'cancel_url' => 'http://yourdomain.com/payment/cancel',
                'notify_url' => 'http://yourdomain.com/payment/notify',
                'order_id' => $requestBody['order_id'],
                'items' => $requestBody['items'],
                'amount' => $requestBody['amount'],
                'currency' => 'LKR',
                'first_name' => $loggedInUser->firstname, // Replace with dynamic user data
                'last_name' => $loggedInUser->lastname,
                'email' => $loggedInUser->email,
                'phone' => $loggedInUser->mobile_number,
                'address' => $loggedInUser->address,
                'city' => 'Colombo',
                'country' => 'Sri Lanka'
            ];

            // Generate the signature
            $data['hash'] = strtoupper(md5(
                $merchant_id . $data['order_id'] . $data['amount'] . $data['currency'] . strtoupper(md5($merchant_secret))
            ));

            echo json_encode($data);
        } catch (Exception $e) {
            error_log("Initiate Payment Error: " . $e->getMessage()); // Log the exception
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => 'Failed to initiate payment', 'details' => $e->getMessage()]);
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
  }