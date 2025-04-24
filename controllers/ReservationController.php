<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\models\BranchOffer;
use app\models\MealOffers;
use app\models\Offer;
use app\models\Reservation;
use app\models\UnregUser;

class ReservationController extends Controller
{
    public function getReservation()
    {
        if (Application::$app->user) {
            try {
                $branch_id = Application::$app->user->branch_id;

                if (!$branch_id) {
                throw new \Exception("Branch ID is missing for the logged-in user.");
            }

                $reservations = Reservation::findAllByBranch($branch_id);
                echo json_encode($reservations);
            } catch (\Exception $e) {
                // Log the error and return a proper JSON response
                error_log("Error fetching reservation data: " . $e->getMessage());
                http_response_code(500); // Set HTTP status code to 500
                echo json_encode(['error' => 'Failed to fetch reservation data', 'details' => $e->getMessage()]);
            }
        } else {
            http_response_code(401); // Set HTTP status code to 401 (Unauthorized)
            echo json_encode(['error' => 'No user is logged in']);
        }
    }

   //get reservation number
   public function getReservationNumber($pin)
   {
       $reservation = Reservation::findOne(['confirmation_number' => $pin]);
       if ($reservation) {
           echo json_encode(['success' => true, 'reservation' => $reservation]);
       } else {
        echo json_encode(['success' => false, 'message' => 'Invalid PIN.']);
       }
   }

   public function addtableReservation(){
         $data = Application::$app->request->getBody();
         $reservation = new Reservation();
         $reservation->load($data);

         $reservation->confirmation_status = '1';
         if ($reservation->addTable()) {
              echo json_encode(['success' => true, 'message' => 'Reservation added successfully']);
         } else {
              echo json_encode(['success' => false, 'message' => 'Failed to add reservation']);
         }
   }


   public function addtableReservationUnReg(){
         $data = Application::$app->request->getBody();
         $reservation = new UnregUser();

         
         $reservation->load($data);

         $reservation->confirmation_status = '1';
         if ($reservation->addTable()) {
              echo json_encode(['success' => true, 'message' => 'Reservation added successfully']);
         } else {
              echo json_encode(['success' => false, 'message' => 'Failed to add reservation']);
         }
   }



   public function findReservation($userID) {
     $reservation = Reservation::findOneCR([
         'confirmation_status' => '1', 
         'user_id' => $userID
     ]);
 
     if ($reservation !== null) {
         // Success: Reservation found
         echo json_encode([
             'success' => true,
             'reservation' => $reservation
         ]);
     } else {
         // No reservation found
         echo json_encode([
             'success' => false,
             'message' => 'No reservation found.'
         ]);
     }
 }
                                       
}