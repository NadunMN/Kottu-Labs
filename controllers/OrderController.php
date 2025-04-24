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
use app\models\takeawayCart;
use Error;
use app\models\UnregUser;

class OrderController extends Controller
{
    //get order data
    public function getOrderData()
    {
        if (Application::$app->user) {
            try {
                $branch_id = Application::$app->user->branch_id;

                if (!$branch_id) {
                throw new \Exception("Branch ID is missing for the logged-in user.");
            }

                $orders = Order::findOrdersByBranch($branch_id);
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

    public function userGetReservationData($user_id)
    {
        if (Application::$app->user) {
            // Pass just the user_id, not an array
            $reservations = Reservation::findDineInReservations($user_id);
            $reservationData = [];
    
            foreach ($reservations as $reservation) {
                $reservationData[] = $reservation;
            }
    
            echo json_encode($reservationData);
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }

    // Method to get cart data
    public function getReservation($user_id)
    {
        if (Application::$app->user) {
            $reservations = Reservation::findAllreservation(['user_id' => $user_id]);
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
                if($meal['type'] == 'meal'){
                    $orderMeal->meal_id = $meal['id'];
                }else{
                    $orderMeal->offer_id = $meal['id'];
                }
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

    public function updateOrderStatus()
    {
        $body = json_decode(file_get_contents('php://input'), true);

        if (!isset($body['order_id']) || !isset($body['order_status'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid request data']);
            return;
        }

        $orderId = $body['order_id'];
        $newStatus = $body['order_status'];

        $stewardId = $body['steward_id'];
        $chefId = $body['chef_id'];


        // Validate order status
        if (!in_array($newStatus, [0, 1, 2])) { 
            http_response_code(400);
            echo json_encode(['error' => 'Invalid order status']);
            return;
        }

        // Find the order by ID
        $order = Order::findOneOriginal(['order_id' => $orderId]);

        if (!$order) {
            http_response_code(404);
            echo json_encode(['error' => 'Order not found']);
            return;
        }

        // Update the order status and steward ID
        $order->order_status = $newStatus;

        if ($chefId) {
            $order->chef_id = $chefId;

            $order->steward_id = null;

        }

        if ($stewardId) {
            $order->steward_id = $stewardId;
        }

        if ($order->update()) {
            http_response_code(200);
            echo json_encode(['message' => 'Order status updated successfully']);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to update order status']);
        }
    }

    // Function to get order ID
    public function getOrderIdByReservation($reservationId) {
        if (!$reservationId) {
            echo json_encode(['error' => 'Reservation ID is required']);
            http_response_code(400);
            return;
        }
    
        $order = Order::findOrderByReservationId($reservationId);
    
        if (!$order) {
            echo json_encode(['error' => 'No order found for the given reservation ID']);
            http_response_code(404);
            return;
        }
    
        echo json_encode(['order_id' => $order['order_id']]);
        http_response_code(200);
    }

    //Order Status (Accepted, Preparing, Cooked)
    public function updateStatus($request)
    {
        $body = $request->getBody();
        $orderId = $body['order_id'];
        $newStatus = $body['status'];

        // Update status in database
        $success = Order::updateStatus($orderId, $newStatus);

        if ($success) {
            return json_encode(['success' => true]);
        } else {
            return json_encode(['error' => 'Update failed']);
        }
    }


    //take away

        // Method to get cart data
        public function getReservationTakewayData($user_id)
        {
            if (Application::$app->user) {
                $reservations = Reservation::findAllreservationTakeawayOrder(['user_id' => $user_id]);
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
    public function addToTakeawayCart()
    {
        if (Application::$app->user) {
            $cart = new takeawayCart();
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


    // Method to get cart data
    public function gettakeawayCartData($user_id)
    {
        if (Application::$app->user) {
            $carts = takeawayCart::findAllcartMeal(['user_id' => $user_id]);
            $cartData = [];

            foreach ($carts as $cart) {
                $cartData[] = $cart;
            }

            echo json_encode($cartData);
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }

        //delete order data in order table
        public function deletetakeawayCart()
        {
            if (Application::$app->user) {
                $cart = new takeawayCart();
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

        //clear cart data
    public function cleartakeawayCart()
    {
        if (Application::$app->user) {
            $cart = new takeawayCart();
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

        // Function to get order meals data
        public function gettakeawayBookedData($user_id)
        {
            if (Application::$app->user) {
                $orderMeals = OrderMeals::findAllBookedMealTakeaway(['user_id' => $user_id]);
                $orderMealData = [];
    
                foreach ($orderMeals as $orderMeal) {
                    $orderMealData[] = $orderMeal;
                }
    
                echo json_encode($orderMealData);
            } else {
                echo json_encode(['error' => 'No user is logged in']);
            }
        }

    public function managerOrderHistory()
    {
        if (Application::$app->user) {
            $branch_id = Application::$app->user->branch_id;
            $orderHistory = Order::getOrderHistory($branch_id);

            echo json_encode($orderHistory);

        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }

    public function managerOrderDetails($id)
{
    if (Application::$app->user) {
        try {
            $order_id = $id;
            $orderItems = Order::getOrderDetails($order_id);


            
            // Make sure we're setting the correct content type
            header('Content-Type: application/json');
            
            $response = [
                'items' => $orderItems
            ];

            echo json_encode($response);
            exit; // Make sure we stop execution after sending the response
        } catch (\Exception $e) {
            // Set HTTP response code
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['error' => $e->getMessage()]);
            exit;
        }
    } else {
        // Set HTTP response code
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode(['error' => 'No user is logged in']);
        exit;
    }
}


    public function orderMealsConfirmation(){
        if (Application::$app->user) {


            error_log("Order Meals Confirmation called"); // Log the function call for debugging
            $orderMeals = new OrderMeals();
            $orderMeals->loadData(Application::$app->request->getBody());

            $orderId = $orderMeals->order_id; // Assuming you have the order ID from the request

            $orderMeals->orderMealsStatusUpdate(
                ['status' => 'completed'],   // SET clause
                ['order_id' => $orderId]            // WHERE clause
            );
                        
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }

    public function orderMealsAcceptance(){
        if (Application::$app->user) {


            error_log("Order Meals Confirmation called"); // Log the function call for debugging
            $orderMeals = new OrderMeals();
            $orderMeals->loadData(Application::$app->request->getBody());

            $orderId = $orderMeals->order_id; // Assuming you have the order ID from the request

            $orderMeals->orderMealsStatusUpdate(
                ['status' => 'Preparing'],   // SET clause
                ['order_id' => $orderId]            // WHERE clause
            );
                        
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }


    public function getOrderDetails($reservationNo)
{
    if (!$reservationNo) {
        http_response_code(400);
        echo json_encode(['error' => 'Reservation number is required']);
        return;
    }

    // Fetch the order using the reservation number
    $order = Order::findOrderByReservationId($reservationNo);

    if (!$order) {
        http_response_code(404);
        echo json_encode(['error' => 'Order not found']);
        return;
    }

    // Fetch detailed order items
    $orderDetails = Order::getOrderDetails($order['order_id']);

    if (!$orderDetails) {
        http_response_code(404);
        echo json_encode(['error' => 'Order details not found']);
        return;
    }

    // Prepare the response
    $items = [];
    $totalPrice = 0;

    foreach ($orderDetails as $detail) {
        $items[] = [
            'meal_name' => $detail['meal_name'],
            'quantity' => $detail['quantity'],
            'price' => $detail['meal_price'],
            'total' => $detail['total_price']
        ];
        $totalPrice += $detail['total_price'];
    }

    echo json_encode([
        'order_number' => $order['order_id'],
        'items' => $items,
        'total_price' => $totalPrice
    ]);
}




public function getReservationUnReg($temp_id){

    
        $reservations = UnregUser::findAllreservationUnReg(['temp_id' => $temp_id]);
        $reservationData = [];

        foreach ($reservations as $reservation) {
            $reservationData[] = $reservation;
        }

        echo json_encode($reservationData);
    
}

}




    public function getDineInData()
    {
        if (Application::$app->user) {
            try {
                $branch_id = Application::$app->user->branch_id;

                if (!$branch_id) {
                throw new \Exception("Branch ID is missing for the logged-in user.");
            }

                $orders = Order::findDineInData($branch_id);
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

    public function getTakeAwayData()
    {
        if (Application::$app->user) {
            try {
                $branch_id = Application::$app->user->branch_id;

                if (!$branch_id) {
                throw new \Exception("Branch ID is missing for the logged-in user.");
            }

                $orders = Order::findTakeAwayData($branch_id);
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


}

