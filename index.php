<?php
require __DIR__ . "/vendor/autoload.php";
use Steampixel\Route;

// LOAD DOTENV
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
}

// -- HELPERS -- //
function getSubdir(): string {
    return isset($_ENV['APP_SUBDIR']) && !empty($_ENV['APP_SUBDIR']) ? $_ENV['APP_SUBDIR'] : '';
}

require __DIR__ . '/routes/index.php';

Route::run(getSubdir());
