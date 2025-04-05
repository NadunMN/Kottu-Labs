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

class OrderController extends Controller
{
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
}