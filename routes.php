<?php
/** @var \Bramus\Router\Router $router */
use App\Helpers\Misc;
use App\Models\BaseTemplate;
use App\Models\HomeTemplate;

$router->get('/', function () {
    $latte = Misc::latte();
    $latte->render(Misc::getView('home'), new HomeTemplate);
});

$router->get('/about', function () {
    $latte = Misc::latte();
    $latte->render(Misc::getView('about'), new BaseTemplate('About'));
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
    $router->get('/rss', 'UserController@rss');
});

$router->get('/video/(\w+)', 'VideoController@get');

$router->mount('/tag', function () use ($router) {
    $router->get('/([^/]+)', 'TagController@get');
    $router->get('/rss', 'TagController@rss');
});

$router->get('/music/([^/]+)', 'MusicController@get');

// -- Settings -- //
$router->mount('/settings', function () use ($router) {
    $router->get('/', 'SettingsController@index');
    $router->post('/proxy', 'SettingsController@proxy');
});

$router->get('/discover', 'DiscoverController@get');
