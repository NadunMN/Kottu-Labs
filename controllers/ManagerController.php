<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\models\Meal;

class ManagerController extends Controller
{
    public function addmenuItems(){
        $meal = new Meal();
        $meal->load(Application::$app->request->getBody());

        if ($meal->add()) {
            echo json_encode(['success' => true]);
        } else {
            error_log('Meal validation or save failed: ' . json_encode($meal->errors));
            echo json_encode(['success' => false, 'errors' => $meal->errors]);
        }
    }

    

    //get menu data
    public function getmenuItems()
    {
        if (Application::$app->user) {

            
            $userId = Application::$app->user->id;
            $meals = Meal::findAll([]);

            $mealData = [];

            foreach ($meals as $meal) {
                $mealData[] = $meal;
            }

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

        $review = new Meal();
        try {
            $mealId = Application::$app->request->getBody()['meal_olderid'] ?? null;
            if (!$mealId) {
                throw new \Exception('Meal ID not provided');
            }

            $meal = Meal::findOne(['meal_id' => $mealId]);
            if (!$meal) {
                throw new \Exception('Review not found');
            }

            $mealData = Application::$app->request->getBody();
            $review->loadData($mealData);

            if (!$review->update()) {
                throw new \Exception('Failed to update review');
            }

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }


}