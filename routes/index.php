<?php
require __DIR__ . '/assets.php';
require __DIR__ . '/settings.php';
require __DIR__ . "/../helpers/settings_elements.php";
use Steampixel\Route;

// - ROUTING HELPERS - //
function getApi(array $proxy_elements): \Sovit\TikTok\Api {
    $options = [];
    // Proxy config
    if (in_array($proxy_elements, $_COOKIE)) {
        foreach ($proxy_elements as $proxy_element) {
            $options[$proxy_element] = $_COOKIE[$proxy_element];
        }
    }
    $api = new \Sovit\TikTok\Api($options);
    return $api;
}

function getLatte(): \Latte\Engine {
    $subdir = getSubdir();
    $latte = new Latte\Engine;
    $latte->setTempDirectory(__DIR__ . '/../cache/views');
    $latte->addFunction('assets', function (string $name, string $type)  use ($subdir) {
        $path = "{$subdir}/{$type}/{$name}";
        return $path;
    });
    $latte->addFunction('path', function (string $name) use ($subdir) {
        $path = "{$subdir}/{$name}";
        return $path;
    });
    return $latte;
}

function getView(string $template): string {
    return __DIR__ . "/../views/{$template}.latte";
}

Route::add('/', function () {
    $latte = getLatte();
    $latte->render(getView('home'));
});

Route::add("/trending", function () use ($proxy_elements) {
    $cursor = 0;
    if (isset($_GET['cursor']) && is_numeric($_GET['cursor'])) {
        $cursor = (int) $_GET['cursor'];
    }
	$latte = getLatte();
	$api = getApi($proxy_elements);
	$feed = $api->getTrendingFeed($cursor);
	if ($feed) {
		$latte->render(getView('trending'), ['feed' => $feed]);
	} else {
		return 'ERROR!';
	}
});

Route::add("/@([^/]+)", function (string $username) use ($proxy_elements) {
    $cursor = 0;
    if (isset($_GET['cursor']) && is_numeric($_GET['cursor'])) {
        $cursor = (int) $_GET['cursor'];
    }
	$latte = getLatte();
	$api = getApi($proxy_elements);
	$feed = $api->getUserFeed($username, $cursor);
	if ($feed) {
        if ($feed->info->detail->user->privateAccount) {
            http_response_code(400);
            return 'Private account detected! Not supported';
        }
		$latte->render(getView('user'), ['feed' => $feed]);
	} else {
		return 'ERROR!';
	}
});

Route::add('/tag/(\w+)', function (string $name) use ($proxy_elements) {
    $cursor = 0;
    if (isset($_GET['cursor']) && is_numeric($_GET['cursor'])) {
        $cursor = (int) $_GET['cursor'];
    }
	$latte = getLatte();
	$api = getApi($proxy_elements);
	$feed = $api->getChallengeFeed($name, $cursor);
	if ($feed) {
		$latte->render(getView('tag'), ['feed' => $feed]);
	} else {
		return 'ERROR!';
	}
});
