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
            try {
                $payments = Payment::findAll([]);
                echo json_encode($payments);
            } catch (\Exception $e) {
                // Log the error and return a proper JSON response
                error_log("Error fetching payment data: " . $e->getMessage());
                http_response_code(500); // Set HTTP status code to 500
                echo json_encode(['error' => 'Failed to fetch payment data', 'details' => $e->getMessage()]);
            }
        } else {
            http_response_code(401); // Set HTTP status code to 401 (Unauthorized)
            echo json_encode(['error' => 'No user is logged in']);
        }
    }
}