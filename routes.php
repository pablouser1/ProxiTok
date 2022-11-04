<?php
/** @var \Bramus\Router\Router $router */

use App\Helpers\ErrorHandler;
use App\Helpers\Wrappers;
use App\Models\BaseTemplate;

$router->set404(function () {
    ErrorHandler::showText(404, "That endpoint doesn't exist");
});

$router->get('/', function () {
    Wrappers::latte('home', new BaseTemplate('Home'));
});

$router->get('/about', function () {
    Wrappers::latte('about', new BaseTemplate('About'));
});

$router->get('/verify', function () {
    Wrappers::latte('verify', new BaseTemplate('verify'));
});

$router->get('/stream', 'ProxyController@stream');
$router->get('/download', 'ProxyController@download');
$router->get('/redirect', 'RedirectController@redirect');

$router->mount('/trending', function () use ($router) {
    $router->get('/', 'TrendingController@get');
    $router->get('/rss', 'TrendingController@rss');
});

$router->mount('/@([^/]+)', function () use ($router) {
    $router->get('/', 'UserController@get');
    $router->get('/video/(\w+)', 'UserController@video');
    $router->get('/rss', 'UserController@rss');
});

// Deprecated, please use /@USERNAME/video/VIDEO_ID instead
$router->get('/video/(\w+)', 'VideoController@get');
// Workaround that allows /t endpoints
$router->get('/t/([^/]+)', 'VideoController@get');

$router->mount('/tag/([^/]+)', function () use ($router) {
    $router->get('/', 'TagController@get');
    $router->get('/rss', 'TagController@rss');
});

$router->get('/music/([^/]+)', 'MusicController@get');

// -- Settings -- //
$router->mount('/settings', function () use ($router) {
    $router->get('/', 'SettingsController@index');
    $router->post('/general', 'SettingsController@general');
    $router->post('/api', 'SettingsController@api');
    $router->post('/misc', 'SettingsController@misc');
});

$router->get('/discover', 'DiscoverController@get');

// -- EMBED -- //
$router->get('/embed/v2/(\d+)', 'EmbedController@v2');
