<?php

use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;
use app\controllers\UserController;
use app\controllers\ManagerController;
use app\controllers\sendOtp;
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
    $app->router->get('/profile', [$siteController, 'adminDashboard']);
}else if(Application::$app->user && Application::$app->user->position == 'customer') {
    $app->router->get('/profile', [$siteController, 'userDashboard']);
    $app->router->get('/myaccount', [$siteController, 'userProfile']);
}else if(Application::$app->user && Application::$app->user->position == 'chef') {
    $app->router->get('/profile', [$siteController, 'chefDashboard']);
}else if(Application::$app->user && Application::$app->user->position == 'steward') {
    $app->router->get('/profile', [$siteController, 'stewardDashboard']);
}else if(Application::$app->user && Application::$app->user->position == 'manager') {
    $app->router->get('/profile', [$siteController, 'managerDashboard']);
    $app->router->get('/myaccount', [$siteController, 'userProfile']);
}

$app->router->get('/otp', [$siteController, 'otp']);
$app->router->get('/cart', [$siteController, 'cart']);
$app->router->get('/offer', [$siteController, 'offer']);



//thiranis route
$app->router->get('/about',[$siteController, 'about']);
$app->router->get('/cancelReserve',[$siteController, 'cancelReserve']);
$app->router->get('/dinein',[$siteController, 'dinein']);
$app->router->get('/staff',[$siteController, 'staff']);


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

//define route for reservations
$app->router->post('/reservation/add', [$userController, 'addReservation']);
$app->router->get('/reservation/data', [$managerController, 'getReservation']);
$app->router->post('/reservation/delete', [$managerController, 'deleteReservation']);
$app->router->post('/reservation/update', [$managerController, 'updateReservation']);



// Run the application
$app->run();
