<?php
require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/helpers/domains.php";
require __DIR__ . "/helpers/settings_elements.php";

use Jenssegers\Blade\Blade;

function getApi(array $proxy_elements): \Sovit\TikTok\Api {
    $options = [];
    if (in_array($proxy_elements, $_COOKIE)) {
        foreach ($proxy_elements as $proxy_element) {
            $options[$proxy_element] = $_COOKIE[$proxy_element];
        }
    }
    $api = new \Sovit\TikTok\Api($options);
    return $api;
}

$router = new \Bramus\Router\Router();

$router->get('/', function () {
    http_response_code(302);
	header('Location: ./home');
});

$router->get('/home', function () {
    $blade = new Blade('./views', './cache/views');
    echo $blade->render('home');
});

$router->get('/images', function () use ($domains) {
    if (!isset($_GET['url'])) {
		die('You need to send a url!');
	}
    $url = $_GET['url'];
    $host = parse_url($url, PHP_URL_HOST);

    if (!filter_var($url, FILTER_VALIDATE_URL) || !in_array($host, $domains['image'])) {
        die('Not a valid URL');
    }
    $img = file_get_contents($url, false, stream_context_create(['http' => ['ignore_errors' => true]]));
    if ($img) {
        header('Content-Type: image/jpeg');
        echo $img;
    } else {
        echo 'Error while getting image!';
    }
});

$router->get('/audios', function () use ($domains) {
    if (!isset($_GET['url'])) {
		die('You need to send a url!');
	}
    $url = $_GET['url'];
    $host = parse_url($url, PHP_URL_HOST);
    if (!filter_var($url, FILTER_VALIDATE_URL) || !in_array($host, $domains['audio'])) {
        die('Not a valid URL');
    }
    $audio = file_get_contents($url, false, stream_context_create(['http' => ['ignore_errors' => true]]));
    if ($audio) {
        header('Content-Type: audio/mp3');
        echo $audio;
    } else {
        echo 'Error while getting audio!';
    }
});

$router->get('/stream', function () use ($domains) {
	if (!isset($_GET['url'])) {
		die('You need to send a url!');
	}

    $url = $_GET['url'];
    $host = parse_url($url, PHP_URL_HOST);

    if (!filter_var($url, FILTER_VALIDATE_URL) || !in_array($host, $domains['video'])) {
        die('Not a valid URL');
    }

    header('Content-Disposition: attachment; filename="tiktok.mp4"');

    $streamer = new \Sovit\TikTok\Stream();
	$streamer->stream($url);
});

$router->get("/trending", function () use ($proxy_elements) {
    $cursor = 0;
    if (isset($_GET['cursor']) && is_numeric($_GET['cursor'])) {
        $cursor = (int) $_GET['cursor'];
    }
	$blade = new Blade('./views', './cache/views');
	$api = getApi($proxy_elements);
	$feed = $api->getTrendingFeed($cursor);
	if ($feed) {
		echo $blade->render('trending', ['feed' => $feed]);
	} else {
		echo 'ERROR!';
	}
});

$router->get("/@([^/]+)", function (string $username) use ($proxy_elements) {
    $cursor = 0;
    if (isset($_GET['cursor']) && is_numeric($_GET['cursor'])) {
        $cursor = (int) $_GET['cursor'];
    }
	$blade = new Blade('./views', './cache/views');
	$api = getApi($proxy_elements);
	$feed = $api->getUserFeed($username, $cursor);
	if ($feed) {
		echo $blade->render('user', ['feed' => $feed]);
	} else {
		echo 'ERROR!';
	}
});

$router->get("/settings", function () use ($proxy_elements) {
    $blade = new Blade('./views', './cache/views');
    echo $blade->render('settings', ["proxy_elements" => $proxy_elements]);
});

$router->post("/settings", function () use ($proxy_elements) {
    if (in_array($proxy_elements, $_POST)) {
        foreach ($proxy_elements as $proxy_element) {
            setcookie($proxy_element, $_POST[$proxy_element], time()+60*60*24*30, '/', '', true, true);
        }
    }
    http_response_code(302);
	header('Location: ./home');
});

$router->run();
