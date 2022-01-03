<?php
require __DIR__ . "/vendor/autoload.php";
require __DIR__ . "/helpers/domains.php";
require __DIR__ . "/helpers/settings_elements.php";
use Steampixel\Route;

// LOAD DOTENV
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

function getSubdir(): string {
    return $_ENV['APP_SUBDIR'] ? $_ENV['APP_SUBDIR'] : '/';
}

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
    $latte = new Latte\Engine;
    $latte->setTempDirectory('./cache/views');
    $latte->addFunction('assets',  function (string $name, string $type) {
        $subdir = getSubdir();
        $path = "{$subdir}/{$type}/{$name}";
        return $path;
    });
    return $latte;
}

function getView(string $template): string {
    return "./views/{$template}.latte";
}

Route::add('/', function () {
    http_response_code(302);
	header('Location: ./home');
});

Route::add('/home', function () {
    $latte = getLatte();
    $latte->render('./views/home.latte');
});

Route::add('/images', function () use ($domains) {
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
        return $img;
    } else {
        return 'Error while getting image!';
    }
});

Route::add('/audios', function () use ($domains) {
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
        return $audio;
    } else {
        return 'Error while getting audio!';
    }
});

Route::add('/stream', function () use ($domains) {
	if (!isset($_GET['url'])) {
		die('You need to send a url!');
	}

    $url = $_GET['url'];
    $host = parse_url($url, PHP_URL_HOST);

    if (!filter_var($url, FILTER_VALIDATE_URL) || !in_array($host, $domains['video'])) {
        die('Not a valid URL');
    }

    if (isset($_GET['download'])) {
        header('Content-Disposition: attachment; filename="tiktok.mp4"');
    }

    $streamer = new \Sovit\TikTok\Stream();
	$streamer->stream($url);
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

Route::add("/settings", function () use ($proxy_elements) {
    $latte = getLatte();
    $latte->render(getView('settings'), ["proxy_elements" => $proxy_elements]);
});

Route::add("/settings", function () use ($proxy_elements) {
    if (in_array($proxy_elements, $_POST)) {
        foreach ($proxy_elements as $proxy_element) {
            setcookie($proxy_element, $_POST[$proxy_element], time()+60*60*24*30, '/', '', true, true);
        }
    }
    http_response_code(302);
	header('Location: ./home');
}, 'POST');

Route::run(getSubdir());
