<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\models\BranchOffer;
use app\models\MealOffers;
use app\models\Offer;
use app\models\Reservation;


class ReservationController extends Controller
{
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

}