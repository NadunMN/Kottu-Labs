<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\models\Order;
use app\models\Reservation;
use app\models\User;

class DashboardController extends Controller
{

    public function getProfit()
    {
        if (Application::$app->user) {
            try {
                $orders = Order::findAllProfit([]);
                echo json_encode($orders);
            } catch (\Exception $e) {
                // Log the error and return a proper JSON response
                error_log("Error fetching order data: " . $e->getMessage());
                http_response_code(500); // Set HTTP status code to 500
                echo json_encode(['error' => 'Failed to fetch order data', 'details' => $e->getMessage()]);
            }
        } else {
            http_response_code(401); // Set HTTP status code to 401 (Unauthorized)
            echo json_encode(['error' => 'No user is logged in']);
        }
    }


    public function getRegistration()
    {
        if (Application::$app->user) {
            try {
                $user = new User();
                $registrations = $user->getRegistration([]);
                echo json_encode($registrations);
            } catch (\Exception $e) {
                // Log the error and return a proper JSON response
                error_log("Error fetching order data: " . $e->getMessage());
                http_response_code(500); // Set HTTP status code to 500
                echo json_encode(['error' => 'Failed to fetch order data', 'details' => $e->getMessage()]);
            }
        } else {
            http_response_code(401); // Set HTTP status code to 401 (Unauthorized)
            echo json_encode(['error' => 'No user is logged in']);
        }
    }

    public function orderCount()
    {
        if (Application::$app->user) {
            try {
                $orders = Order::orderCount([]);
                echo json_encode($orders);
            } catch (\Exception $e) {
                // Log the error and return a proper JSON response
                error_log("Error fetching order data: " . $e->getMessage());
                http_response_code(500); // Set HTTP status code to 500
                echo json_encode(['error' => 'Failed to fetch order data', 'details' => $e->getMessage()]);
            }
        } else {
            http_response_code(401); // Set HTTP status code to 401 (Unauthorized)
            echo json_encode(['error' => 'No user is logged in']);
        }
    }

    public function getRegistrationsCount()
    {
        if (Application::$app->user) {
            try {
                $user = new User();
                
                $registrations = $user->getRegistrationCount([]);
                echo json_encode($registrations);
            } catch (\Exception $e) {
                // Log the error and return a proper JSON response
                error_log("Error fetching registration data: " . $e->getMessage());
                http_response_code(500); // Set HTTP status code to 500
                echo json_encode(['error' => 'Failed to fetch registration data', 'details' => $e->getMessage()]);
            }
        } else {
            http_response_code(401); // Set HTTP status code to 401 (Unauthorized)
            echo json_encode(['error' => 'No user is logged in']);
        }
    }


    public function getTopCustomenrs()
    {
        if (Application::$app->user) {
            try {
                $user = new Reservation();
                
                $reservations = $user->topCustemor([]);
                echo json_encode($reservations);
            } catch (\Exception $e) {
                // Log the error and return a proper JSON response
                error_log("Error fetching customer data: " . $e->getMessage());
                http_response_code(500); // Set HTTP status code to 500
                echo json_encode(['error' => 'Failed to fetch customer data', 'details' => $e->getMessage()]);
            }
        } else {
            http_response_code(401); // Set HTTP status code to 401 (Unauthorized)
            echo json_encode(['error' => 'No user is logged in']);
        }
    }


    

}
?>

