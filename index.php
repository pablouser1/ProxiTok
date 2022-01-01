<?php
require __DIR__ . "/vendor/autoload.php";

use Leaf\Blade;

function startStream (string $url) {
	$streamer = new \Sovit\TikTok\Stream();
	$streamer->stream($url);
}

$app = new Leaf\App;

$app->get('/', function () use ($app) {
	$app->response()->page('./views/home.html');
});

$app->get('/stream', function () {
	if (!isset($_GET['url'])) {
		die('You need to send a url!');
	}
    startStream($_GET['url']);
});

$app->get("/trending", function () {
    $cursor = 0;
    if (isset($_GET['cursor']) && is_numeric($_GET['cursor'])) {
        $cursor = (int) $_GET['cursor'];
    }
	$blade = new Blade('./views', './cache/views');
	$api = new \Sovit\TikTok\Api();
	$feed = $api->getTrendingFeed($cursor);
	if ($feed) {
		echo $blade->render('trending', ['feed' => $feed]);
	} else {
		echo 'ERROR!';
	}
});

/* CURRENTLY NOT WORKING
$app->get('/videos', function () {
    if (!isset($_GET['id'])) {
		die('You need to send an id param!');
	}
    $item = $_GET['id'];
	$api = new \Sovit\TikTok\Api();
    // Using an url
    if (filter_var($item, FILTER_VALIDATE_URL)) {
        $feed = $api->getVideoByUrl($item);
    } else {
        // Assume is an id
        $feed = $api->getVideoByID($item);
    }

    if ($feed) {
        var_dump($feed);
    }

});
*/

$app->get("/@([^/]+)", function (string $username) {
    $cursor = 0;
    if (isset($_GET['cursor']) && is_numeric($_GET['cursor'])) {
        $cursor = (int) $_GET['cursor'];
    }
	$blade = new Blade('./views', './cache/views');
	$api = new \Sovit\TikTok\Api();
	$feed = $api->getUserFeed($username, $cursor);
	if ($feed) {
		echo $blade->render('user', ['feed' => $feed]);
	} else {
		echo 'ERROR!';
	}
});

$app->run();
