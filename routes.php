<?php
/** @var \Bramus\Router\Router $router */
use App\Helpers\Misc;
use App\Helpers\Wrappers;
use App\Models\BaseTemplate;

$router->get('/', function () {
    $latte = Wrappers::latte();
    $latte->render(Misc::getView('home'), new BaseTemplate('Home'));
});

$router->get('/about', function () {
    $latte = Wrappers::latte();
    $latte->render(Misc::getView('about'), new BaseTemplate('About'));
});

$router->get('/verify', function () {
    $latte = Wrappers::latte();
    $latte->render(Misc::getView('verify'), new BaseTemplate('Verify'));
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

/**
 * @deprecated Please use /@username/video/id instead
 */
$router->get('/video/(\w+)', 'VideoController@get');

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
});

$router->get('/discover', 'DiscoverController@get');

// -- EMBED -- //
$router->get('/embed/v2/(\d+)', 'EmbedController@v2');
