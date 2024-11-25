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
}