<?php

use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;
use app\controllers\UserController;
use app\controllers\ManagerController;
use app\controllers\MealController;
use app\controllers\OfferController;
use app\controllers\ReservationController;
use app\controllers\OrderController;
use app\controllers\FeedbacksController;
use app\controllers\sendOtp;
use app\controllers\PaymentController; // Add missing import
use app\models\User;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

if (!isset($_ENV['DB_DSN'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'])) {
    throw new Exception('Database configuration is incomplete.');
}

$config = [
    'userClass' => \app\models\User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];

$app = new Application(dirname(__DIR__), $config);
$siteController = new SiteController();
$authController = new AuthController();
$userController = new UserController();
$managerController = new ManagerController();
$mealController = new MealController();
$offerController = new OfferController();
$reservationController = new ReservationController();
$orderController = new OrderController();
$feedbacksController = new FeedbacksController();
$paymentController = new PaymentController(); // Add PaymentController instance


// Define routes
$app->router->get('/', [$siteController, 'home']);
$app->router->get('/contact', [$siteController, 'contact']);
$app->router->post('/contact', [$siteController, 'contact']);

$app->router->get('/login', [$authController, 'login']);
$app->router->post('/login', [$authController, 'login']);

$app->router->get('/register', [$authController, 'register']);
$app->router->post('/register', [$authController, 'register']);

$app->router->get('/logout', [$authController, 'logout']);
// $app->router->get('/profile', [$siteController, 'userProfile']);

if (Application::$app->user && Application::$app->user->position == 'admin') {
    //admin routes
    $app->router->get('/profile', [$siteController, 'adminDashboard']);
    $app->router->get('/profile/dashboard', [$siteController, 'dashboardAdmin']);
    $app->router->get('/profile/staff', [$siteController, 'staffAdmin']);
    $app->router->get('/profile/update-menu', [$siteController, 'updatemenuAdmin']);
    $app->router->get('/profile/update-offers', [$siteController, 'updateoffersAdmin']);
    $app->router->get('/profile/feedbacks', [$siteController, 'feedbacksAdmin']);

}else if(Application::$app->user && Application::$app->user->position == 'customer') {
    $app->router->get('/profile', [$siteController, 'userDashboard']);
    $app->router->get('/myaccount', [$siteController, 'userProfile']);
}else if(Application::$app->user && Application::$app->user->position == 'chef') {

    $app->router->get('/profile', [$siteController, 'chefDashboard']);
    $app->router->get('/profile/view-order', [$siteController, 'viewOrderChef']);
    $app->router->get('/profile/update-menu', [$siteController, 'updateMenuChef']);

}else if(Application::$app->user && Application::$app->user->position == 'steward') {
    $app->router->get('/profile', [$siteController, 'stewardDashboard']);
    
    //steward
    $app->router->get('/profile/view-order-status', [$siteController, 'orderstatusSteward']);
    $app->router->get('/profile/customer-arrivals', [$siteController, 'customerarrivalsSteward']);
    $app->router->get('/profile/customer-payments', [$siteController, 'paymentsSteward']);

}else if(Application::$app->user && Application::$app->user->position == 'manager') {
    $app->router->get('/profile', [$siteController, 'managerDashboard']);
    $app->router->get('/myaccount', [$siteController, 'userProfile']);
}

$app->router->get('/successreservation', [$siteController, 'successReservation']);
$app->router->get('/confirmreservation', [$siteController, 'confirmReservation']);
$app->router->get('/cart', [$siteController, 'cart']);
$app->router->get('/offer', [$siteController, 'offer']);



//thiranis route
$app->router->get('/about',[$siteController, 'about']);
$app->router->get('/cancelReserve',[$siteController, 'cancelReserve']);
$app->router->get('/dinein',[$siteController, 'dinein']);
$app->router->get('/staff',[$siteController, 'staff']);
$app->router->get('/chefdashboard',[$siteController, 'chefdashboard']);


//maheshs routes
$app->router->get('/payment',[$siteController, 'payment']);
$app->router->get('/cash_confirmation',[$siteController, 'cash_confirmation']);
$app->router->get('/card_payment',[$siteController, 'card_payment']);


//ranuga's routes
$app->router->get('/menu',[$siteController, 'menu']);
$app->router->get('/selectBranch',[$siteController, 'selectBranch']);
$app->router->get('/homeMenu',[$siteController, 'homeMenu']);
$app->router->get('/managerDashboard/viewUsers',[$siteController, 'viewUsers']);

// Define route for getting user data
$app->router->get('/user/data', [$userController, 'getUserData']);
$app->router->post('/user/delete', [$userController, 'deleteUser']);
$app->router->post('/user/update', [$userController, 'updateUser']);

//define route for review and rating
$app->router->post('/review/add', [$userController, 'addReview']);
$app->router->get('/review/data', [$userController, 'getReviewData']);
$app->router->post('/review/delete', [$userController, 'deleteReviewData']);
$app->router->post('/review/update', [$userController, 'updateReviewData']);

//define route for menuItems
$app->router->post('/menuitem/add', [$managerController, 'addmenuItems']);
$app->router->get('/menuitem/data', [$managerController, 'getmenuItems']);
$app->router->post('/mealitem/delete', [$managerController, 'deletemenuItems']);
$app->router->post('/menuitem/update', [$managerController, 'updatemenuItems']);


//define route for offers
$app->router->get('/offer/get', [$offerController, 'getOffers']);
$app->router->get('/offer/offerview', [$siteController, 'viewOfferMain']);

//define route for reservations
$app->router->post('/reservation/add', [$userController, 'addReservation']);
$app->router->get('/reservation/data', [$managerController, 'getReservation']);
$app->router->get('/reservation/otp', [$managerController, 'getOtp']);
$app->router->post('/reservation/delete', [$managerController, 'deleteReservation']);
$app->router->post('/reservation/update', [$managerController, 'updateReservation']);


//offers
$app->router->post('/offer/add', [$offerController, 'addOffer']);
$app->router->post('/offer/publish', [$offerController, 'publishOffer']);
$app->router->get('/addMeal', [$siteController, 'addMeal']);


//new enter pin
$app->router->get('/enterpin', [$siteController, 'enterpin']);


//menu
$app->router->get('/getMealsmenu', function() use ($mealController) {
    $branchId = $_GET['branchId'] ?? null;
    $selectionId = $_GET['selectionId'] ?? null;
    $searchTerm = $_GET['search'] ?? null;
    $mealController->mealsByBranch($branchId, $selectionId, $searchTerm);
});


//offer
$app->router->get('/getofferlist', function() use ($offerController) {
    $branchId = $_GET['branchId'] ?? null;
    $searchTerm = $_GET['search'] ?? null;
    $offerController->offersByBranch($branchId, $searchTerm);
});

$app->router->get('/get/offer', function() use ($offerController) {
    $offerId = $_GET['offerId'] ?? null;
    
    $offerController->offerview($offerId);
});

$app->router->post('/offer/delete', [$offerController, 'deleteOffer']);


$app->router->get('/reservation/otp', function() use ($reservationController) {
    $pin = $_GET['pin'] ?? null;
    $reservationController->getReservationNumber($pin);
});

//reservation Number
$app->router->post('/reservationNumber', [$authController, 'reservationNumberGenerator']);
$app->router->post('/reservation/addtable', [$reservationController, 'addtableReservation']);

//define route for feedbacks
$app->router->get('/feedback/get', [$feedbacksController, 'getReviews']);
$app->router->post('/feedback/delete', [$feedbacksController, 'deleteReviews']);


$app->router->get('/offer/getpublished', [$offerController, 'getAllPublishedOffers']);

// order data
$app->router->get('/order/data', [$orderController, 'getOrderData']);



//get reservationData
$app->router->get('/getconfirmReservation', function() use ($reservationController) {
    $userId = $_GET['userId'] ?? null;
    $reservationController->findReservation($userId);
});


//cart
$app->router->post('/cart/add', [$orderController, 'addToCart']);

$app->router->get('/getMealscart', function() use ($orderController) {
    $userId = $_GET['userId'] ?? null;
    $orderController->getCartData($userId);
});

$app->router->post('/removeFromCart', [$orderController, 'deleteCart']);
$app->router->post('/updateCartQuantity', [$orderController, 'updateCartQuantity']);
$app->router->post('/clearCart', [$orderController, 'clearCart']);

$app->router->post('/placeOrder', [$orderController, 'placeOrder']);
$app->router->post('/placeOrderMeal', [$orderController, 'processOrderMeals']);


$app->router->get('/getReservationDataOrder', function() use ($orderController) {
    $userId = $_GET['userId'] ?? null;
    $orderController->getReservationData($userId);
});

$app->router->get('/getBookedDataOrder', function() use ($orderController) {
    $userId = $_GET['userId'] ?? null;
    $orderController->getBookedData($userId);
});

$app->router->get('/getOrderState', function() use ($orderController) {
    $reservationId = $_GET['reservationNo'] ?? null;
    $orderController->getOrderState($reservationId);
});

//staff
$app->router->post('/staff/add', [$userController, 'addStaff']);
$app->router->get('/staff/data', [$userController, 'getStaff']);


//get payment data
$app->router->get('/payment/data', [$paymentController, 'getPaymentData']);


// Run the application
$app->run();
