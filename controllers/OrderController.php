<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\models\BranchOffer;
use app\models\MealOffers;
use app\models\Offer;
use app\models\Reservation;
use app\models\Order;
use app\models\Cart;
use app\models\OrderMeals;
use app\models\Payment;

class OrderController extends Controller
{
    //get order data
    public function getOrderData()
    {
        if (Application::$app->user) {
            try {
                $orders = Order::findAll([]);
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
    
    // Method to get cart data
    public function getCartData($user_id)
    {
        if (Application::$app->user) {
            $carts = Cart::findAllcartMeal(['user_id' => $user_id]);
            $cartData = [];

            foreach ($carts as $cart) {
                $cartData[] = $cart;
            }

            echo json_encode($cartData);
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }

    // Method to get cart data
    public function getReservationData($user_id)
    {
        if (Application::$app->user) {
            $reservations = Reservation::findAllreservationOrder(['user_id' => $user_id]);
            $reservationData = [];

            foreach ($reservations as $reservation) {
                $reservationData[] = $reservation;
            }

            echo json_encode($reservationData);
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }


    //store order data in order table
    public function addToCart()
    {
        if (Application::$app->user) {
            $cart = new Cart();
            $cart->loadData(Application::$app->request->getBody());

            if ($cart->save()) {
                echo json_encode(['success' => 'Meal Added successfully']);
            } else {
                echo json_encode(['error' => 'Failed to add Meal']);
            }
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }

    //delete order data in order table
    public function deleteCart()
    {
        if (Application::$app->user) {
            $cart = new Cart();
            $cart->loadData(Application::$app->request->getBody());

            if ($cart->delete()) {
                echo json_encode(['success' => 'Meal deleted successfully']);
            } else {
                echo json_encode(['error' => 'Failed to delete Meal']);
            }
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }

    //update quantity of mealin cart
    public function updateCartQuantity()
    {
        if (Application::$app->user) {
            $cart = new Cart();
            $cart->loadData(Application::$app->request->getBody());

            if ($cart->update()) {
                echo json_encode(['success' => 'Meal updated successfully']);
            } else {
                echo json_encode(['error' => 'Failed to update Meal']);
            }
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }

    //clear cart data
    public function clearCart()
    {
        if (Application::$app->user) {
            $cart = new Cart();
            $cart->loadData(Application::$app->request->getBody());

            if ($cart->clear()) {
                echo json_encode(['success' => 'Cart cleared successfully']);
            } else {
                echo json_encode(['error' => 'Failed to clear cart']);
            }
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }
    public function placeOrder()
    {
        if (Application::$app->user) {
            $order = new Order();
            $order->loadData(Application::$app->request->getBody());
    
            if ($order->save()) {
                $orderId = $order->order_id;
    
                $payment = new Payment();
                $payment->payment_date = $order->order_date;
                $payment->payment_type = 'none'; // Ensure this is a valid type per your DB
                $payment->payment_amount = $order->order_price;
                $payment->payment_status = 0; // Matches the int type (0 for pending)
                $payment->order_id = $orderId;
    
              
    
                // Generate a unique payment_id if not auto-increment
                // Example using uniqid (adjust based on your needs)
                $payment->payment_id = uniqid('pay_', true);
    
                if ($payment->save()) {
                    echo json_encode(['order_id' => $orderId]);
                } else {
                    echo json_encode(['error' => 'Failed to save payment']);
                }
            } else {
                echo json_encode(['error' => 'Failed to place order']);
            }
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }

    // New function to process order meals
    public function processOrderMeals()
{
    if (Application::$app->user) {
        // Retrieve purchased meals from the request body
        $purchasedMeals = Application::$app->request->getBody();
        // error_log(print_r($orderId, true)); // Log the purchased meals for debugging
        // exit;

        foreach ($purchasedMeals as $meal) {
            // Dump meal ID
            // error_log("Meal ID: " . $meal['id']);
        
            if (!isset($meal['id'], $meal['quantity'])) {
                echo json_encode(['error' => 'Invalid meal data']);
                return;
            }
        
            $orderMeal = new OrderMeals();
            $orderMeal->order_id = $meal['order_id']; // Assuming you have the order ID from the request
            $orderMeal->meal_id = $meal['id'];
            $orderMeal->quantity = $meal['quantity'];
            $orderMeal->user_id = $meal['user_id']; // Assuming you have the user ID from the session
            $orderMeal->status = $meal['status']; // Set the status to 'pending' or any other default value
        
            if (!$orderMeal->save()) {
                echo json_encode(['error' => 'Failed to save order meal for meal ID ' . $meal['id']]);
                return;
            }
        }
        
        

        echo json_encode(['success' => 'Order meals processed successfully']);
    } else {
        echo json_encode(['error' => 'No user is logged in']);
    }
}

    // Function to get order meals data
    public function getBookedData($user_id)
    {
        if (Application::$app->user) {
            $orderMeals = OrderMeals::findAllBookedMeal(['user_id' => $user_id]);
            $orderMealData = [];

            foreach ($orderMeals as $orderMeal) {
                $orderMealData[] = $orderMeal;
            }

            echo json_encode($orderMealData);
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }


    public function getOrderState($reservation_no)
    {
        if (Application::$app->user) {
            header('Content-Type: application/json'); // Set JSON header
            $order = Order::findOneOriginal(['reservation_no' => $reservation_no]);
            if ($order) {
                echo json_encode(['exists' => 1]);
            } else {
                echo json_encode(['exists' => 0]);
            }
            exit(); // Stop script execution after sending JSON
        } else {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'No user is logged in']);
            exit();
        }
    }






}