<?php
namespace App\Controllers;

class ProxyController {
    const VALID_TIKTOK_DOMAINS = [
        "tiktokcdn.com", "tiktokcdn-us.com", "tiktok.com"
    ];

    static private function isValidDomain(string $url) {
        $host = parse_url($url, PHP_URL_HOST);
        $host_split = explode('.', $host);
        return count($host_split) === 3 && in_array($host_split[1] . '.' . $host_split[2], self::VALID_TIKTOK_DOMAINS);
    }

    static public function stream() {
        if (!isset($_GET['url'])) {
            die('You need to send a url!');
        }

        $url = $_GET['url'];
        if (!filter_var($url, FILTER_VALIDATE_URL) || !self::isValidDomain($url)) {
            die('Not a valid URL');
        }

        if (isset($_GET['download'])) {
            // Download
            $downloader = new \Sovit\TikTok\Download();
            $filename = 'tiktok-video';
            if (isset($_GET['id'], $_GET['user'])) {
                $filename .= '-' . $_GET['user'] . '-' . $_GET['id'];
            }
            $downloader->url($url, $filename, 'mp4');
        } else {
            // Stream
            $streamer = new \Sovit\TikTok\Stream();
            $streamer->stream($url);
        }
    }
}
