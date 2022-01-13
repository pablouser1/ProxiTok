<?php
require __DIR__ . '/assets.php';
require __DIR__ . '/settings.php';
require __DIR__ . '/following.php';
use Steampixel\Route;
use Helpers\Misc;
use Helpers\Error;

Route::add('/', function () {
    $latte = Misc::latte();
    $latte->render(Misc::getView('home'));
});

Route::add('/about', function () {
    $latte = Misc::latte();
    $latte->render(Misc::getView('about'));
});

Route::add("/trending", function () {
    $cursor = 0;
    if (isset($_GET['cursor']) && is_numeric($_GET['cursor'])) {
        $cursor = (int) $_GET['cursor'];
    }
	$api = Misc::api();
	$feed = $api->getTrendingFeed($cursor);
	if ($feed->meta->success) {
        $latte = Misc::latte();
		$latte->render(Misc::getView('trending'), ['feed' => $feed]);
	} else {
		Error::show($feed->meta);
	}
});

Route::add("/@([^/]+)", function (string $username) {
    $cursor = 0;
    if (isset($_GET['cursor']) && is_numeric($_GET['cursor'])) {
        $cursor = (int) $_GET['cursor'];
    }
	$api = Misc::api();
	$feed = $api->getUserFeed($username, $cursor);
	if ($feed->meta->success) {
        if ($feed->info->detail->user->privateAccount) {
            http_response_code(400);
            return 'Private account detected! Not supported';
        }
        $latte = Misc::latte();
		$latte->render(Misc::getView('user'), ['feed' => $feed]);
	} else {
		Error::show($feed->meta);
	}
});

Route::add('/video/([^/]+)', function (string $video_id) {
    $api = Misc::api();
    $item = $api->getVideoByID($video_id);
    if ($item->meta->success) {
        $latte = Misc::latte();
        $latte->render(Misc::getView('video'), ['item' => $item]);
    } else {
        Error::show($item->meta);
    }
});

Route::add('/tag/(\w+)', function (string $name) {
    $cursor = 0;
    if (isset($_GET['cursor']) && is_numeric($_GET['cursor'])) {
        $cursor = (int) $_GET['cursor'];
    }
	$api = Misc::api();
	$feed = $api->getChallengeFeed($name, $cursor);
	if ($feed->meta->success) {
        $latte = Misc::latte();
		$latte->render(Misc::getView('tag'), ['feed' => $feed]);
	} else {
		Error::show($feed->meta);
	}
});
