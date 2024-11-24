<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\core\Request;
use app\core\Response;
use app\models\User;
use app\core\Model;
use app\models\Review;

class UserController extends Controller
{

    public Model $model;
    public Review $reviewuser;

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


    //add review
    public function addReview()
    {
        $review = new Review();
        $review->loadData(Application::$app->request->getBody());

        if ($review->validate() && $review->save()) {
            echo json_encode(['success' => true]);
        } else {
            error_log('Review validation or save failed: ' . json_encode($review->errors));
            echo json_encode(['success' => false, 'errors' => $review->errors]);
        }
    }

    //get review data
    public function getReviewData()
    {
        if (Application::$app->user) {

            $userId = Application::$app->user->id;
            $reviews = Review::findAll(['user_id' => $userId]);

            $reviewData = [];

            foreach ($reviews as $review) {
                $reviewData[] = $review;
            }

            echo json_encode($reviewData);
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }


    //review deletion
    public function deleteReviewData(){
        
        try {
            $reviewId = Application::$app->request->getBody()['review_id'] ?? null;
            

            if (!$reviewId) {
                throw new \Exception('Review ID not provided');
            }

            // Debugging statement
            error_log("Review ID received: " . $reviewId);

            $review = Review::findOne(['review_id' => $reviewId]);

            if (!$review) {
                throw new \Exception('Review not found');
            }

            if (!$review->delete()) {
                throw new \Exception('Failed to delete review');
            }

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }


    public function updateReviewData()
    {

        $review = new Review();
        try {
            $reviewId = Application::$app->request->getBody()['review_id'] ?? null;
            if (!$reviewId) {
                throw new \Exception('Review ID not provided');
            }

            $review = Review::findOne(['review_id' => $reviewId]);
            if (!$review) {
                throw new \Exception('Review not found');
            }

            $reviewData = Application::$app->request->getBody();
            $review->loadData($reviewData);

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