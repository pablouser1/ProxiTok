<?php
require __DIR__ . "/vendor/autoload.php";

$dotenv = new josegonzalez\Dotenv\Loader(__DIR__ . '/.env');
$dotenv->parse();
$dotenv->toEnv();

// ROUTER
$router = new Bramus\Router\Router();
$router->setNamespace('\App\Controllers');

require __DIR__ . '/routes.php';

$router->run();
