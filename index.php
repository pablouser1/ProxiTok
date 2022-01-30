<?php
require __DIR__ . "/vendor/autoload.php";

// LOAD DOTENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// ROUTER
$router = new Bramus\Router\Router();
$router->setNamespace('\App\Controllers');

require __DIR__ . '/routes.php';

$router->run();
