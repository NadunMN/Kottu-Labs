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

    public function orderReports(Request $request, Response $response){
        if (Application::$app->user) {
            $orders = Order::findAllOrders();
            echo json_encode($orders);
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }

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



}