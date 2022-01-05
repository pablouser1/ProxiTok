<?php
require __DIR__ . "/vendor/autoload.php";
use Steampixel\Route;
use Helpers\Misc;

// LOAD DOTENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require __DIR__ . '/routes/index.php';

Route::run(Misc::getSubDir());
