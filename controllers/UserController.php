<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\core\Request;
use app\core\Response;
use app\models\User;
use app\models\Review;
use app\models\Reservation;
use app\models\UnregUser;

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


    public function getStaff(){
        $user = new User();
        $staffData = $user->getStaffData();

        if ($staffData) {
            echo json_encode($staffData);
        } else {
            echo json_encode(['error' => 'No staff data found']);
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


//    public function addReservation(){
//         $reservation = new Reservation();
//         $reservation->loadData(Application::$app->request->getBody());

//         if ($reservation->save()) {
//             echo json_encode(['success' => true]);
//         } else {
//             error_log('Reservation validation or save failed: ' . json_encode($reservation->errors));
//             echo json_encode(['success' => false, 'errors' => $reservation->errors]);
//         }
//    }

   public function addStaff(){
        $user = new User();
        $user->loadData(Application::$app->request->getBody());

        if ($user->validate() && $user->save()) {
            echo json_encode(['success' => true]);
        } else {
            error_log('Staff validation or save failed: ' . json_encode($user->errors));
            echo json_encode(['success' => false, 'errors' => $user->errors]);
        }

   }

   public function deleteStaff(){
        try {
            $userId = Application::$app->request->getBody()['id'] ?? null;
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


   public function addReservation()
   {
    //    error_log('Add Reservation method called');
       $reservation = new Reservation();
       $reservation->loadData(Application::$app->request->getBody());

        error_log(print_r($reservation, true));
        // exit;

       // Validate required fields
       if (empty($reservation->branch_id) || empty($reservation->reservation_time)) {
           echo json_encode(['success' => false, 'message' => 'Branch and reservation time are required']);
           return;
       }
   
       // Fetch seat availability for the specific branch and time
       $result = $reservation->getSeatAvailability([
        'branch_id' => $reservation->branch_id,
        'reservation_time' => $reservation->reservation_time // Ensure this is passed!
    ]);

    error_log(print_r($result, true));
    // exit;

   
       if ($result === false) {
           echo json_encode(['success' => false, 'message' => 'Failed to fetch seat data']);
           return;
       }
   
       $seatData = $result[0] ?? null;
       if (!$seatData) {
           echo json_encode(['success' => false, 'message' => 'Branch not found']);
           return;
       }
   
       $availableSeats = $seatData['seats'] - $seatData['reserved_seats'];

       error_log(print_r($availableSeats, true));
    //    exit;
   
       if ($reservation->number_of_guests <= $availableSeats) {
           if ($reservation->save()) {
                $reservationNo=$reservation->reservation_no;
               echo json_encode(['success' => $reservationNo]);
               error_log('Reservation saved successfully: ' . json_encode($reservation));
           } else {
               error_log('Reservation save failed: ' . json_encode($reservation->errors));
               // Sanitize errors before sending to frontend
               echo json_encode(['success' => false, 'errors' => $reservation->errors]);
           }
       } else {
           echo json_encode(['success' => false, 'message' => 'Not enough available seats']);
       }
   }





    public function getStaffData($userId)
    {
         if (Application::$app->user) {
              $userId = Application::$app->user->id;
              $user1 = User::findOne(['id' => $userId]);
              echo json_encode($user1);
         } else {
              echo json_encode(['error' => 'No user is logged in']);
         }
    }


    public function addUnreg()
{
    $unregUser = new UnregUser();
    $unregUser->loadData(Application::$app->request->getBody());

    // Log the UnregUser object as a JSON string
    error_log('UnregUser data: ' . json_encode($unregUser));
    // exit;

    if ($unregUser->save()) {
        $tempId = $unregUser->temp_id; // Assuming temp_id is the primary key or unique identifier
        echo json_encode(['success' => $tempId]);
    } else {
        // Log validation errors if saving fails
        error_log('Unregistered user validation or save failed: ' . json_encode($unregUser->errors));
        echo json_encode(['success' => false, 'errors' => $unregUser->errors]);
    }
}


public function getUnreg($id){
    // $unregUser = new UnregUser();

    $unregUser = UnregUser::findOne(['temp_id' => $id]);
    $regUser = Reservation::findOne(['reservation_no' => $id]);


    if ($unregUser) {
        echo json_encode(['type' => 'unregUser', 'data' => $unregUser]);
    } elseif ($regUser) {
        echo json_encode(['type' => 'regUser', 'data' => $regUser]);
    } else {
        echo json_encode(['error' => 'No user found']);
    }

    
}


public function acceptUnregData(){
    $unregUser = new UnregUser();
    $unregUser->loadData(Application::$app->request->getBody());

    // Log the UnregUser object as a JSON string
    // error_log('UnregUser data: ' . json_encode($unregUser));
    // exit;

    if ($unregUser->update()) {
        // $tempId = $unregUser->temp_id; // Assuming temp_id is the primary key or unique identifier
        echo json_encode(['success' => true]);
    } else {
        // Log validation errors if saving fails
        error_log('Unregistered user validation or save failed: ' . json_encode($unregUser->errors));
        echo json_encode(['success' => false, 'errors' => $unregUser->errors]);
    }
}



    
   

    



  
}