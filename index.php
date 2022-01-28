<?php
require __DIR__ . "/vendor/autoload.php";

// LOAD DOTENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// ROUTER
$router = new Bramus\Router\Router();
require __DIR__ . '/routes/index.php';
$router->run();
