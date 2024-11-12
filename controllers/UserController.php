<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\core\Request;
use app\core\Response;
use app\models\User;

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

    public function deleteUser(Request $request, Response $response)
    {
        try {
            $userId = $request->getBody()['id'] ?? null;
            if (!$userId) {
                throw new \Exception('User ID not provided');
            }

            // Debugging statement
            error_log("User ID received: " . $userId);

            $user = User::findOne(['id' => $userId]);
            if (!$user) {
                throw new \Exception('User not found');
            }

            if (!$user->delete()) {
                throw new \Exception('Failed to delete user');
            }

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

}