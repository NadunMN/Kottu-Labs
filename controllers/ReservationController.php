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

}