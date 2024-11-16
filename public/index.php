<?php

use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;
use app\controllers\UserController;
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
} else if(Application::$app->user && Application::$app->user->position == 'customer') {
    $app->router->get('/profile', [$siteController, 'userDashboard']);
    $app->router->get('/myaccount', [$siteController, 'userProfile']);
}else if(Application::$app->user && Application::$app->user->position == 'chef') {
    $app->router->get('/profile', [$siteController, 'chefDashboard']);
}else if(Application::$app->user && Application::$app->user->position == 'steward') {
    $app->router->get('/profile', [$siteController, 'stewardDashboard']);
}


$app->router->get('/about',[$siteController, 'about']);
$app->router->get('/cancelReserve',[$siteController, 'cancelReserve']);
$app->router->get('/dinein',[$siteController, 'dinein']);

// Define route for getting user data
$app->router->get('/user/data', [$userController, 'getUserData']);
$app->router->post('/user/delete', [$userController, 'deleteUser']);
$app->router->post('/user/update', [$userController, 'updateUser']);

// Run the application
$app->run();
