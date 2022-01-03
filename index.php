<?php
require __DIR__ . "/vendor/autoload.php";
use Steampixel\Route;

// LOAD DOTENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

// -- HELPERS -- //
function getSubdir(): string {
    return isset($_ENV['APP_SUBDIR']) && !empty($_ENV['APP_SUBDIR']) ? $_ENV['APP_SUBDIR'] : '';
}

require __DIR__ . '/routes/index.php';

Route::run(getSubdir());
