<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\core\Request;
use app\core\Response;
use app\models\User;
use app\core\Model;

class UserController extends Controller
{

    public Model $model;

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

    public function updateUser(Request $request, Response $response)
    {
        try {
            // Get the currently logged-in user
            $user = Application::$app->user;
            if (!$user) {
                throw new \Exception('No user is logged in');
            }

            

            $userData = $request->getBody();
            $user->loadData($userData);

            // Debugging statements
            // error_log("User Data: " . json_encode($userData));
            // error_log("User Object: " . json_encode($user->toArray()));

            if (!$user->update()) {
                throw new \Exception('Failed to update user');
            }

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

}