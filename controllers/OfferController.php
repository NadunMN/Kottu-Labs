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
    if (!$offer->load(Application::$app->request->getBody()) || !$offer->validate()) {
        echo json_encode(['success' => false, 'errors' => $offer->errors, 'message' => 'Invalid offer data']);
        return;
    }
    
    
    try {
        if ($offer->add()) {

            $offerId = $offer->offer_id;
            // var_dump($offerId);
            // exit;
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
                if (!$branchOffer->validate() || !$branchOffer->add()) {
                    throw new \Exception('Failed to add branch offer for branch ' . $branchId . ': ' . json_encode($branchOffer->errors));
                }
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
                if (!$mealOffer->validate() || !$mealOffer->add()) {
                    throw new \Exception('Failed to add meal offer for meal ' . $mealId . ': ' . json_encode($mealOffer->errors));
                }
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
    public function offersByBranch($branchId, $searchTerm)
    {
        if (Application::$app->user) {
            // Fetch meals by branch ID
            
                $offers = Offer::findAllWithoutGroup(['branch_id' => $branchId], $searchTerm);
            
            $offerData = [];
            foreach ($offers as $offer) {
                $offerData[] = $offer;
            }
            echo json_encode($offerData);
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }

        //get menu data
        public function getOffers()
        {
            if (Application::$app->user) {
    
                
                $offers = Offer::findAll([]);
    
                $offerData = [];
    
                foreach ($offers as $offer) {
                    $offerData[] = $offer;
                }
    
    
                echo json_encode($offerData);
            } else {
                echo json_encode(['error' => 'No user is logged in']);
            }
        }

        //delete offer
        public function deleteOffer()
        {
            $offer = new Offer();
            $offer->load(Application::$app->request->getBody());
    
            if ($offer->delete()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'errors' => $offer->errors]);
            }
        }

        //get offer id for edit
        public function getOfferDetailsOne($offerId)
        {
            $offer = Offer::findOfferOne(['offer_id' => $offerId]);
            
            if ($offer) {
                echo json_encode($offer);
            } else {
                echo json_encode(['error' => 'Offer not found']);
            }
        }

        //update offer
        public function updateoffer()
        {
            $offer = new Offer();

            try {
                $offerId = Application::$app->request->getBody()['offer_id'] ?? null;
                if (!$offerId) {
                    throw new \Exception('Offer ID not provided');
                }

                $offer = Offer::findOne(['offer_id' => $offerId]);
                if (!$offer) {
                    throw new \Exception('Offer not found');
                }

                $offerData = Application::$app->request->getBody();
                $offer->loadData($offerData);

                if (!$offer->update()) {
                    throw new \Exception('Failed to update offer');
                }

                // ✅ Success response
                echo json_encode(['success' => true]);

            } catch (\Exception $e) {
                
                error_log($e->getMessage());
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        }
        
        //publish offer
        public function publishOffer()
        {
            $offer = new Offer();
            $offer->load(Application::$app->request->getBody());
    
            if ($offer->updatePublish()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'errors' => $offer->errors]);
            }
        }

        public function getAllPublishedOffers(){
            $offers = Offer::findAllOriginal(['publish_status' => 1]);
    
            $offerData = [];
    
            foreach ($offers as $offer) {
                $offerData[] = $offer;
            }
    
            echo json_encode($offerData);

        }

        public function offerview($offerId){
            $offer = Offer::findAllMealsOffers(['offer_id' => $offerId]);
            $offerData = [];
            $offerData[] = $offer;
            echo json_encode($offerData);
        }
        


}