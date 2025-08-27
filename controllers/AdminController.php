<?php
namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\core\Response;
use app\models\Order;
use app\models\Reservation;
use app\models\User;
use app\models\BranchMeal;
use app\models\Meal;
use app\models\OrderMeals;

class AdminController extends Controller{

    // public function orderReports(Request $request, Response $response) {
    //     if (!Application::$app->user) {
    //         echo json_encode(['error' => 'No user is logged in']);
    //         return;
    //     }
        
    //     // Get filter parameters from the request
    //     $startDate = $request->getBody()['startDate'] ?? null;
    //     $endDate = $request->getBody()['endDate'] ?? null;
    //     $branch = $request->getBody()['branch'] ?? null;
    //     $minPrice = $request->getBody()['minPrice'] ?? null;
    //     $maxPrice = $request->getBody()['maxPrice'] ?? null;
        
    //     // Apply server-side filtering if parameters are provided
    //     // This can improve performance by reducing data sent to the client
    //     if ($startDate || $endDate || $branch || $minPrice || $maxPrice) {
    //         $orders = Order::findOrdersByFilters($startDate, $endDate, $branch, $minPrice, $maxPrice);
    //     } else {
    //         // Original behavior - get all orders if no filters
    //         $orders = Order::findAllOrders();
    //     }
        
    //     echo json_encode($orders);
    // }

    public function mealsReport(Request $request, Response $response) {
        if (!Application::$app->user) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
    
        // Get filter parameters from request
        $body = $request->getBody();
        $startDate = $body['startDate'] ?? '1970-01-01';
        $endDate = $body['endDate'] ?? date('Y-m-d');
        $branchId = $body['branchId'] ?? null;
    
        // Get filtered meal data
        $mealData = OrderMeals::findFilteredMealOrders($startDate, $endDate, $branchId);
        
        if ($mealData === false) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'error' => 'Database error',
                'message' => 'Failed to fetch meal report data'
            ]);
            exit;
        }
    
        header('Content-Type: application/json');
        echo json_encode($mealData);
        exit;
    }

    public function reservationReport(Request $request, Response $response) {
        if (!Application::$app->user) {
            header('Content-Type: application/json');
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }
    
        // Get filter parameters from request
        $body = $request->getBody();
        $startDate = $body['startDate'] ?? '1970-01-01';
        $endDate = $body['endDate'] ?? date('Y-m-d');
        $timeSlot = $body['timeSlot'] ?? null;
        $branchId = $body['branchId'] ?? null;
    
        // Get filtered reservation data
        $reservationData = Reservation::findFilteredReservations($startDate, $endDate, $timeSlot, $branchId);
        
        if ($reservationData === false) {
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'error' => 'Database error',
                'message' => 'Failed to fetch reservation report data'
            ]);
            exit;
        }
    
        header('Content-Type: application/json');
        echo json_encode($reservationData);
        exit;
    }



}