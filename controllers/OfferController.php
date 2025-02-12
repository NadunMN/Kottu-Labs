<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\models\BranchOffer;
use app\models\MealOffers;
use app\models\Offer;


class OfferController extends Controller
{
   //add new offer
   public function addOffer(){
    $offer = new Offer();
    $offer->load(Application::$app->request->getBody());
    
    try {
        if ($offer->add()) {

            $offerId = $offer->offer_id;
            $branchOffer = new BranchOffer();
            $branchOffer->offer_id = $offerId;

            $mealOffer = new MealOffers();
            $mealOffer->offer_id = $offerId;


            $branches = [];
            $meals = [];

            foreach (Application::$app->request->getBody() as $key => $value) {
                // Assuming branch keys are named like branch2, branch3, etc.
                if (strpos($key, 'branch') === 0) {
                    $branches[] = $value;
                }
            }
  
        if (count($branches) > 0) {
            foreach ($branches as $branchId) {
                $branchOffer = new BranchOffer();
                $branchOffer->offer_id = $offerId;
                $branchOffer->branch_id = $branchId;

                if (!$branchOffer->add()) {
                    throw new \Exception('Failed to add meal to branches_meal for branch ' . $branchId . ': ' . json_encode($branchOffer->errors));
                }
            }

            
            echo json_encode(['success' => true]);
        } else {
            throw new \Exception('No branch IDs provided');
        }

        

        foreach (Application::$app->request->getBody() as $key => $value) {
            // Assuming meal keys are named like meal2, meal3, etc.
            if (strpos($key, 'meal') === 0) {
                $meals[] = $value;
            }
        }

        if (count($meals) > 0) {
            foreach ($meals as $mealId) {

                $mealOffer = new MealOffers();
                $mealOffer->offer_id = $offerId;
                $mealOffer->meal_id = $mealId;

                if (!$mealOffer->add()) {
                    throw new \Exception('Failed to add offer to meal_offer for branch ' . $mealId . ': ' . json_encode($mealOffer->errors));
                }
            }
        } else {
            throw new \Exception('No meal IDs provided');
        }


        
        } else {
            throw new \Exception('Meal validation or save failed: ' . json_encode($offer->errors));
        }
    } catch (\Exception $e) {
        error_log($e->getMessage());
        echo json_encode(['success' => false, 'errors' => $offer->errors, 'message' => $e->getMessage()]);
    }
}

    //get menu data
    public function offersByBranch($branchId)
    {
        if (Application::$app->user) {
            // Fetch meals by branch ID
            
                $offers = Offer::findAllWithoutGroup(['branch_id' => $branchId]);
            
            $offerData = [];
            foreach ($offers as $offer) {
                $offerData[] = $offer;
            }
            echo json_encode($offerData);
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }



    // public function findMealData(){
    //     $meal = new Meal();
    //     $meal->load(Application::$app->request->getBody());
    //     $mealData = $meal->findMealData();
    //     echo json_encode($mealData);
    // }
}