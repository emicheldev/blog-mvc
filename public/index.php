<?php
require_once '../vendor/autoload.php';

use Tracy\Debugger;

Debugger::enable();

$dotenv = \Dotenv\Dotenv::createMutable('../');
$dotenv->load();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$router = new App\Router();
$router->run();