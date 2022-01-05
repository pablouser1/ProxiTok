<?php
use Steampixel\Route;

/**
 * Check if an url has a valid domain
 * @param string $url URL you want to check
 * @return bool
 */
function isValidDomain(string $url): bool {
    $valid_domains = [
        "tiktokcdn.com", "tiktokcdn-us.com", "tiktok.com"
    ];
    $host = parse_url($url, PHP_URL_HOST);
    $host_split = explode('.', $host);
    return count($host_split) === 3 && in_array($host_split[1] . '.' . $host_split[2], $valid_domains);
}

Route::add('/images', function () {
    if (!isset($_GET['url'])) {
		die('You need to send a url!');
	}
    $url = $_GET['url'];
    if (!filter_var($url, FILTER_VALIDATE_URL) || !isValidDomain($url)) {
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

Route::add('/audios', function () {
    if (!isset($_GET['url'])) {
		die('You need to send a url!');
	}
    $url = $_GET['url'];

    if (!filter_var($url, FILTER_VALIDATE_URL) || !isValidDomain($url)) {
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

Route::add('/stream', function () {
	if (!isset($_GET['url'])) {
		die('You need to send a url!');
	}

    $url = $_GET['url'];
    if (!filter_var($url, FILTER_VALIDATE_URL) || !isValidDomain($url)) {
        die('Not a valid URL');
    }

    if (isset($_GET['download'])) {
        // Download
        $downloader = new \Sovit\TikTok\Download();
        $downloader->url($url,"tiktok-video",'mp4');
    } else {
        // Stream
        $streamer = new \Sovit\TikTok\Stream();
        $streamer->stream($url);
    }
});
