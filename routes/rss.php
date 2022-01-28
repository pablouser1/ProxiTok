<?php

/**@var Bramus\Router\Router $router */

use Helpers\Misc;
use Helpers\RSS;
use Helpers\ErrorHandler;

$router->all("/@([^/]+)/rss", function (string $username) {
	$api = Misc::api();
	$feed = $api->getUserFeed($username);
	if ($feed->meta->success) {
        $feed = RSS::build('/@'.$username, $feed->info->detail->user->nickname, $feed->info->detail->user->signature, $feed->items);
        // Setup headers
        RSS::setHeaders('user.rss');
        echo $feed;
	} else {
		ErrorHandler::show($feed->meta);
	}
});

$router->all("/trending/rss", function () {
	$api = Misc::api();
	$feed = $api->getTrendingFeed();
	if ($feed->meta->success) {
        $feed = RSS::build('/trending', 'Trending', 'Tiktok trending', $feed->items);
        // Setup headers
        RSS::setHeaders('trending.rss');
        echo $feed;
	} else {
		ErrorHandler::show($feed->meta);
	}
});

$router->all("/tag/(\w+)/rss", function (string $name) {
    $api = Misc::api();
	$feed = $api->getChallengeFeed($name);
	if ($feed->meta->success) {
        $feed = RSS::build("/tag/{$name}", "{$name} Tag", $feed->info->detail->challenge->desc, $feed->items);
        // Setup headers
        RSS::setHeaders('tag.rss');
        echo $feed;
	} else {
		ErrorHandler::show($feed->meta);
	}
});
