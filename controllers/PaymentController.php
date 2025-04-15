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
  }