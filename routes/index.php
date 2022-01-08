<?php
require __DIR__ . '/assets.php';
require __DIR__ . '/settings.php';
require __DIR__ . '/following.php';
use Steampixel\Route;
use Helpers\Misc;

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
	$latte = Misc::latte();
	$api = Misc::api();
	$feed = $api->getTrendingFeed($cursor);
	if ($feed) {
		$latte->render(Misc::getView('trending'), ['feed' => $feed]);
	} else {
		return 'ERROR!';
	}
});

Route::add("/@([^/]+)", function (string $username) {
    $cursor = 0;
    if (isset($_GET['cursor']) && is_numeric($_GET['cursor'])) {
        $cursor = (int) $_GET['cursor'];
    }
	$latte = Misc::latte();
	$api = Misc::api();
	$feed = $api->getUserFeed($username, $cursor);
	if ($feed) {
        if ($feed->info->detail->user->privateAccount) {
            http_response_code(400);
            return 'Private account detected! Not supported';
        }
		$latte->render(Misc::getView('user'), ['feed' => $feed]);
	} else {
		return 'ERROR!';
	}
});

Route::add('/video/(\d+)', function (string $video_id) {
    $latte = Misc::latte();
    $api = Misc::api();
    $item = $api->getVideoByID($video_id);
    if ($item) {
        $latte->render(Misc::getView('video'), ['item' => $item]);
    } else {
        return 'ERROR!';
    }
});

Route::add('/tag/(\w+)', function (string $name) {
    $cursor = 0;
    if (isset($_GET['cursor']) && is_numeric($_GET['cursor'])) {
        $cursor = (int) $_GET['cursor'];
    }
	$latte = Misc::latte();
	$api = Misc::api();
	$feed = $api->getChallengeFeed($name, $cursor);
	if ($feed) {
		$latte->render(Misc::getView('tag'), ['feed' => $feed]);
	} else {
		return 'ERROR!';
	}
});
