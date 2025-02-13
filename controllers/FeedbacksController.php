<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\models\BranchOffer;
use app\models\MealOffers;
use app\models\Offer;
use app\models\Review;


class FeedbacksController extends Controller
{
   public function getReviews()
   {
    if (Application::$app->user) {

        $reviews = Review::findAlladmin([]);

        $reviewData = [];

        foreach ($reviews as $review) {
            $reviewData[] = $review;
        }

        echo json_encode($reviewData);
    } else {
        echo json_encode(['error' => 'No user is logged in']);
    }
   }

   public function deleteReviews(){
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

}