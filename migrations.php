<?php

use app\core\Application;
use app\controllers\SiteController;
use app\controllers\AuthController;

require_once __DIR__.'/vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ],
    'userClass' => \app\models\User::class // Add this line
];

$app = new Application(__DIR__, $config);

$app->db->applyMigrations();