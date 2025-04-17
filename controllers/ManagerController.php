<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Application;
use app\models\Meal;
use app\models\Reservation;
use app\models\BranchMeal;

class ManagerController extends Controller
{
    public function addmenuItems() {
        $meal = new Meal();
        
        // Debug to see what's coming in
        error_log("FILES: " . print_r($_FILES, true));
        error_log("POST: " . print_r($_POST, true));
        
        // Handle file upload
        $uploadedFile = $_FILES['meal_photo'] ?? null;
        $filePath = '';
        
        if ($uploadedFile && $uploadedFile['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($uploadedFile['type'], $allowedTypes)) {
                echo json_encode(['success' => false, 'message' => 'Unsupported file type']);
                return;
            }
        
            if ($uploadedFile['size'] > 2 * 1024 * 1024) {
                echo json_encode(['success' => false, 'message' => 'File is too large']);
                return;
            }
        
            // Define target directory for images
            $targetDir = "public/uploads/menu/";
        
            // Create directory if it doesn't exist
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }
        
            // Generate unique filename
            $fileName = uniqid() . "_" . basename($uploadedFile["name"]);
            $targetFilePath = $targetDir . $fileName;
        
            // Move uploaded file to target directory
            if (move_uploaded_file($uploadedFile["tmp_name"], $targetFilePath)) {
                $filePath = "/" . $targetFilePath; // Add leading slash for URL formatting
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to upload image']);
                return;
            }
        }
        
        // Load form data
        $meal->load($_POST);
        
        // Translate meal_description ID to text
        if (isset($_POST['meal_description'])) {
            $descriptionMap = [
                '1' => 'All',
                '2' => 'Classic Kottu',
                '3' => 'Dolphin Kottu',
                '4' => 'Cheese Kottu',
                '5' => 'String Hopper Kottu',
                '6' => 'KL Special Fried Rice',
                '7' => 'Pasta',
                '8' => 'Appetizers',
                '9' => 'KL Inventions',
                '10' => 'Wraps & Rotti Sandwiches',
                '11' => 'Parata',
                '12' => 'Devilled Portions',
                '13' => 'Mocktails',
                '14' => 'Beverages'
            ];
            
            $id = $_POST['meal_description'];
            if (isset($descriptionMap[$id])) {
                $meal->meal_description = $descriptionMap[$id];
            }
        }
        
        // Set the image path if an image was uploaded
        if ($filePath) {
            $meal->meal_photo = $filePath;
        }
    
        try {
            // Add the meal
            if ($meal->add()) {
                $mealId = $meal->meal_id;
    
                // Get the branch_id of the logged-in manager
                $manager = Application::$app->user;
                $branchId = $manager->branch_id;
    
                // Create branch-meal relationship
                $branchMeal = new BranchMeal();
                $branchMeal->meal_id = $mealId;
                $branchMeal->branch_id = $branchId;
                $branchMeal->meal_status = 1; // default to active
    
                if ($branchMeal->add()) {
                    echo json_encode(['success' => true, 'meal_id' => $mealId]);
                } else {
                    throw new \Exception('Failed to add to branch_meal: ' . json_encode($branchMeal->errors));
                }
    
            } else {
                throw new \Exception('Meal validation or save failed: ' . json_encode($meal->errors));
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'errors' => $meal->errors ?? [], 'message' => $e->getMessage()]);
        }
    }
    

    //get menu data
    public function getmenuItems()
    {
        if (Application::$app->user) {

            
            $meals = Meal::findAll([]);

            $mealData = [];

            foreach ($meals as $meal) {
                $mealData[] = $meal;
            }


            echo json_encode($mealData);
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }
    
    public function getManagerBranch()
    {
        $manager = Application::$app->user;

        if ($manager) {
            $branchName = $manager->branchName();  
            echo json_encode(['branchName' => $branchName]);  
        } else {
            echo json_encode(['error' => 'Manager not logged in']);
        }
    }


    public function getmenuItemsManager()
    {
        if (Application::$app->user) {
            // Use manager's branch_id from logged-in user (fallback to 1)
            $branchId = Application::$app->user->branch_id ?? 1;

            // Pass the correct int instead of an array
            $meals = Meal::findAllForManager($branchId);

            echo json_encode($meals);
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }



    //review deletion
    public function deletemenuItems(){
        try {
            $menuId = Application::$app->request->getBody()['meal_id'] ?? null;

            if (!$menuId) {
                throw new \Exception('Meal ID not provided');
            }

            // Debugging statement
            error_log("Meal ID received: " . $menuId);

            $meal = Meal::findOne(['meal_id' => $menuId]);

            if (!$meal) {
                throw new \Exception('meal not found');
            }

            if (!$meal->delete()) {
                throw new \Exception('Failed to delete review');
            }

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updatemenuItems()
    {
        $meal = new Meal();

        try {
            $mealId = Application::$app->request->getBody()['meal_id'] ?? null;
            if (!$mealId) {
                throw new \Exception('Meal ID not provided');
            }

            $meal = Meal::findOne(['meal_id' => $mealId]);
            if (!$meal) {
                throw new \Exception('Meal not found');
            }

            $mealData = Application::$app->request->getBody();
            $meal->loadData($mealData);

            if (!$meal->update()) {
                throw new \Exception('Failed to update meal');
            }

            // ✅ Success response
            echo json_encode(['success' => true]);

        } catch (\Exception $e) {
            
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }



    //get menu data
    public function getReservation()
    {
        if (Application::$app->user) {
            $reservations = Reservation::findAll([]);

            $reservationData = [];

            foreach ($reservations as $reservation) {
                $reservationData[] = $reservation;
            }

            echo json_encode($reservationData);
        } else {
            echo json_encode(['error' => 'No user is logged in']);
        }
    }

    

    // get reservation number
    public function getOtp() {
        // $pin = $_GET['pin'] ?? '';
        $pin = '12345';
        error_log("Received PIN: " . $pin);
        $otp = '12345'; 
    
        if ($pin === $otp) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
    

        //reservation deletion
        public function deleteReservation(){
            try {
                $reservationId = Application::$app->request->getBody()['reservation_no'] ?? null;
                
    
                if (!$reservationId) {
                    throw new \Exception('reservation ID not provided');
                }
    
                // Debugging statement
                error_log("Reservation ID received: " . $reservationId);
    
                $reservation = Reservation::findOne(['reservation_no' => $reservationId]);
    
                if (!$reservation) {
                    throw new \Exception('reservation not found');
                }
    
                if (!$reservation->delete()) {
                    throw new \Exception('Failed to delete reservation');
                }
    
                echo json_encode(['success' => true]);
            } catch (\Exception $e) {
                // Log the exception or handle it as needed
                error_log($e->getMessage());
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
        }



        //update reservation
        public function updateReservation()
    {
        $reservation = new Reservation();
        try {
            $reservationId = Application::$app->request->getBody()['reservation_no'] ?? null;
            if (!$reservationId) {
                throw new \Exception('Reservation ID not provided');
            }

            $reservation = Reservation::findOne(['reservation_no' => $reservationId]);
            if (!$reservation) {
                throw new \Exception('reservation not found');
            }

            $reservationData = Application::$app->request->getBody();
            $reservation->loadData($reservationData);

            if (!$reservation->update()) {
                throw new \Exception('Failed to update reservation');
            }

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            // Log the exception or handle it as needed
            error_log($e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updatestatus()
    {
        try {
            $requestData = Application::$app->request->getBody();
            $meal_id = $requestData['meal_id'] ?? null;
            $status = $requestData['status'] ?? null;

            if (!$meal_id || !is_numeric($status)) {
                throw new \Exception("Invalid input data: meal_id=$meal_id, status=$status");
            }

            // Get branch_id from the logged-in user
            $user = Application::$app->user;
            $branch_id = $user->branch_id ?? null;

            if (!$branch_id) {
                throw new \Exception("Branch ID not found for current user.");
            }

            // Debug log
            error_log("Updating meal status: meal_id=$meal_id, branch_id=$branch_id, status=$status");

            // Find the branch meal record or create it if it doesn't exist
            $branchMeal = \app\models\BranchMeal::findOne([
                'meal_id' => $meal_id,
                'branch_id' => $branch_id
            ]);

            if (!$branchMeal) {
                // If record doesn't exist, create a new one
                $branchMeal = new \app\models\BranchMeal();
                $branchMeal->meal_id = $meal_id;
                $branchMeal->branch_id = $branch_id;
                $branchMeal->meal_status = $status;
                
                if (!$branchMeal->add()) {
                    throw new \Exception("Failed to create branch meal record.");
                }
            } else {
                // Use the direct updateAvailability method since it's available
                if (!$branchMeal->updateAvailability($meal_id, $branch_id, $status)) {
                    throw new \Exception("Failed to update meal availability.");
                }
            }

            echo json_encode(['success' => true]);
        } catch (\Exception $e) {
            error_log("Error in updatestatus: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }



    
}