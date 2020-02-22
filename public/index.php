<?php
require_once '../vendor/autoload.php';
$dotenv = \Dotenv\Dotenv::createMutable('../');
$dotenv->load();

$router = new App\Router();
$router->run();