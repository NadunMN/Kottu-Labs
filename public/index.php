<?php
require_once __DIR__.'/../vendor/autoload.php';

use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;

$app = new Application(dirname(__DIR__));
$siteController = new SiteController();
$authController = new AuthController();

// Define routes
$app->router->get('/', [$siteController, 'home']);
$app->router->get('/contact', [$siteController, 'contact']);
$app->router->post('/contact', [$siteController, 'handleContact']);

$app->router->get('/login', [$authController, 'login']);
$app->router->post('/login', [$authController, 'login']);

$app->router->get('/register', [$authController, 'register']);
$app->router->post('/register', [$authController, 'register']);

// Run the application
$app->run();