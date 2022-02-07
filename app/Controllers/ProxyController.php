<?php
namespace App\Controllers;

class ProxyController {
    const VALID_TIKTOK_DOMAINS = [
        "tiktokcdn.com", "tiktokcdn-us.com", "tiktok.com"
    ];

    static private function isValidDomain(string $url) {
        $host = parse_url($url, PHP_URL_HOST);
        $host_split = explode('.', $host);
        $host_count = count($host_split);
        if ($host_count === 2) {
            // Using no watermark
            return in_array($host_split[0] . '.' . $host_split[1], self::VALID_TIKTOK_DOMAINS);
        } elseif ($host_count === 3) {
            return in_array($host_split[1] . '.' . $host_split[2], self::VALID_TIKTOK_DOMAINS);
        }
        return false;
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
            $watermark = isset($_GET['watermark']);
            $downloader->url($url, $filename, $watermark);
        } else {
            // Stream
            $streamer = new \Sovit\TikTok\Stream();
            $streamer->stream($url);
        }
    }
}
