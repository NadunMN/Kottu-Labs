<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;

class UserController extends Controller
{
    public function getUserData()
    {
        if (Application::$app->user) {
            $userData = Application::$app->user->toArray();
            $userJson = json_encode($userData);
            echo $userJson;
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }
}