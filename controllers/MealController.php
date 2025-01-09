<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\models\Meal;

class MealController extends Controller
{
    //get menu data
    public function mealsByBranch($branchId)
    {
        if (Application::$app->user) {
            // Fetch meals by branch ID
            $meals = Meal::findAllWithoutGroup(['branch_id' => $branchId]);
            $mealData = [];
            foreach ($meals as $meal) {
                $mealData[] = $meal;
            }
            echo json_encode($mealData);
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }
}