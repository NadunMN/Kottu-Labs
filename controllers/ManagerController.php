<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\models\Meal;
use app\models\Reservation;

class ManagerController extends Controller
{
    public function addmenuItems(){
        $meal = new Meal();
        $meal->load(Application::$app->request->getBody());

        try {
            if ($meal->add()) {
                echo json_encode(['success' => true]);
            } else {
                throw new \Exception('Meal validation or save failed: ' . json_encode($meal->errors));
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'errors' => $meal->errors, 'message' => $e->getMessage()]);
        }
    }

    //get menu data
    public function getmenuItems()
    {
        if (Application::$app->user) {

            
            $meals = Meal::findAll([]);

            $mealData = [];

            foreach ($meals as $meal) {
                $mealData[] = $meal;
            }

            // var_dump($mealData);
            // exit;


            echo json_encode($mealData);
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }

    //review deletion
    public function deletemenuItems(){
        try {
            $menuId = Application::$app->request->getBody()['meal_id'] ?? null;

            if (!$menuId) {
                throw new \Exception('Meal ID not provided');
            }

            // Debugging statement
            error_log("Meal ID received: " . $menuId);

            $meal = Meal::findOne(['meal_id' => $menuId]);

            if (!$meal) {
                throw new \Exception('meal not found');
            }

            if (!$meal->delete()) {
                throw new \Exception('Failed to delete review');
            }

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updatemenuItems()
    {
        $meal = new Meal();
        try {
            $mealId = Application::$app->request->getBody()['older_id'] ?? null;
            if (!$mealId) {
                throw new \Exception('Meal ID not provided');
            }

            $meal = Meal::findOne(['meal_id' => $mealId]);
            if (!$meal) {
                throw new \Exception('Review not found');
            }

            $mealData = Application::$app->request->getBody();
            $meal->loadData($mealData);

            if (!$meal->update()) {
                throw new \Exception('Failed to update review');
            }

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    //get menu data
    public function getReservation()
    {
        if (Application::$app->user) {
            $reservations = Reservation::findAll([]);

            $reservationData = [];

            foreach ($reservations as $reservation) {
                $reservationData[] = $reservation;
            }

            echo json_encode($reservationData);
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }

        //reservation deletion
        public function deleteReservation(){
            try {
                $reservationId = Application::$app->request->getBody()['reservation_no'] ?? null;
                
    
                if (!$reservationId) {
                    throw new \Exception('reservation ID not provided');
                }
    
                // Debugging statement
                error_log("Reservation ID received: " . $reservationId);
    
                $reservation = Reservation::findOne(['reservation_no' => $reservationId]);
    
                if (!$reservation) {
                    throw new \Exception('reservation not found');
                }
    
                if (!$reservation->delete()) {
                    throw new \Exception('Failed to delete reservation');
                }
    
                echo json_encode(['success' => true]);
            } catch (\Exception $e) {
                // Log the exception or handle it as needed
                error_log($e->getMessage());
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        }



        //update reservation
        public function updateReservation()
    {
        $reservation = new Reservation();
        try {
            $reservationId = Application::$app->request->getBody()['reservation_no'] ?? null;
            if (!$reservationId) {
                throw new \Exception('Reservation ID not provided');
            }

            $reservation = Reservation::findOne(['reservation_no' => $reservationId]);
            if (!$reservation) {
                throw new \Exception('reservation not found');
            }

            $reservationData = Application::$app->request->getBody();
            $reservation->loadData($reservationData);

            if (!$reservation->update()) {
                throw new \Exception('Failed to update reservation');
            }

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    


}