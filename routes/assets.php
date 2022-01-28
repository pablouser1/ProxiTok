<?php
const VALID_TIKTOK_DOMAINS = [
    "tiktokcdn.com", "tiktokcdn-us.com", "tiktok.com"
];

/**@var Bramus\Router\Router $router */

/**
 * Check if an url has a valid domain
 * @param string $url URL you want to check
 * @return bool
 */
function isValidDomain(string $url): bool {
    $host = parse_url($url, PHP_URL_HOST);
    $host_split = explode('.', $host);
    return count($host_split) === 3 && in_array($host_split[1] . '.' . $host_split[2], VALID_TIKTOK_DOMAINS);
}

$router->get('/stream', function () {
	if (!isset($_GET['url'])) {
		die('You need to send a url!');
	}

    $url = $_GET['url'];
    if (!filter_var($url, FILTER_VALIDATE_URL) || !isValidDomain($url)) {
        die('Not a valid URL');
    }

    if (isset($_GET['download'])) {
        // Download (video only)
        $downloader = new \Sovit\TikTok\Download();
        $downloader->url($url, "tiktok-video", 'mp4');
    } else {
        // Stream
        $streamer = new \Sovit\TikTok\Stream();
        $streamer->stream($url);
    }
});
