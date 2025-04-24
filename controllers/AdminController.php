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



}