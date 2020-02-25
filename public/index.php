<?php
require_once '../vendor/autoload.php';

use Tracy\Debugger;

Debugger::enable();

$dotenv = \Dotenv\Dotenv::createMutable('../');
$dotenv->load();

$router = new App\Router();
$router->run();