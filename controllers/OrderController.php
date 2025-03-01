<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\models\BranchOffer;
use app\models\MealOffers;
use app\models\Offer;
use app\models\Reservation;
use app\models\Order;

class OrderController extends Controller
{
    // Method to get order data
    public function getOrderData()
    {
        if (Application::$app->user) {
            $orders = Order::findAll([]);

            $orderData = [];

            foreach ($orders as $order) {
                $orderData[] = $order;
            }

            echo json_encode($orderData);
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }
}