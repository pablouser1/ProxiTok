<?php
require __DIR__ . "/../helpers/domains.php";
use Steampixel\Route;

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
