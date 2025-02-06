<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\models\BranchOffer;
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

            $branches = [];
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

        
        } else {
            throw new \Exception('Meal validation or save failed: ' . json_encode($offer->errors));
        }
    } catch (\Exception $e) {
        error_log($e->getMessage());
        echo json_encode(['success' => false, 'errors' => $offer->errors, 'message' => $e->getMessage()]);
    }
}



    // public function findMealData(){
    //     $meal = new Meal();
    //     $meal->load(Application::$app->request->getBody());
    //     $mealData = $meal->findMealData();
    //     echo json_encode($mealData);
    // }
}