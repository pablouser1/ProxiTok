<?php
namespace App\Controllers;

use App\Helpers\Cookies;
use App\Helpers\Misc;

class ProxyController {
    const VALID_TIKTOK_DOMAINS = [
        "tiktokcdn.com", "tiktokcdn-us.com", "tiktok.com"
    ];

    public static function stream() {
        self::checkUrl();
        $url = $_GET['url'];

        $options = Misc::getScraperOptions();
        $streamer = new \TikScraper\Stream($options);
        $streamer->url($url);
    }

    public static function download() {
        self::checkUrl();
        $method = Cookies::downloader();
        $downloader = new \TikScraper\Download($method, Misc::getScraperOptions());

        // Params
        $id = $_GET['id'] ?? '';
        $watermark = isset($_GET['watermark']);
        $url = $_GET['url'];
        $user = $_GET['user'] ?? '';
        // Filename
        $filename = self::getFilename($id, $user);
        // Running
        $downloader->url($url, $filename, $watermark);
    }

    static private function isValidDomain(string $url): bool {
        $valid = false;
        $host = parse_url($url, PHP_URL_HOST);
        $host_split = explode('.', $host);
        $host_count = count($host_split);
        if ($host_count === 2) {
            // Using no watermark
            $valid = in_array($host_split[0] . '.' . $host_split[1], self::VALID_TIKTOK_DOMAINS);
        } elseif ($host_count === 3) {
            $valid = in_array($host_split[1] . '.' . $host_split[2], self::VALID_TIKTOK_DOMAINS);
        }
        return $valid;
    }

    static private function checkUrl(): void {
        if (!isset($_GET['url'])) {
            die('You need to send a URL');
        }

        if (!filter_var($_GET['url'], FILTER_VALIDATE_URL) || !self::isValidDomain($_GET['url'])) {
            die('Not a valid URL');
        }

    }

    static private function getFilename(string $id, string $user): string {
        $filename = 'tiktok-video-' . $id . '-' . $user;
        return $filename;
    }
}
