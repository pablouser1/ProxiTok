<?php
require __DIR__ . "/vendor/autoload.php";

use Leaf\Blade;

$app = new Leaf\App;

$app->get('/', function () use ($app) {
	$app->response()->page('./views/home.html');
});

$app->get("/users/{user}", function (string $username) {
	$blade = new Blade('./views', './cache/views');
	$api = new \Sovit\TikTok\Api();
	$user = $api->getUserFeed($username);
	if ($user) {
		echo $blade->render('user', ['user' => $user]);
	} else {
		echo 'ERROR!';
	}
});

$app->get('/stream', function () {
	if (!isset($_GET['url'])) {
		die('You need to send a url!');
	}

	// Start streamer
	$streamer = new \Sovit\TikTok\Stream();
	$streamer->stream($_GET['url']);
});

$app->run();
