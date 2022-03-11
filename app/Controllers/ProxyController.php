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

    static private function checkUrl() {
        if (!isset($_GET['url'])) {
            die('You need to send a URL');
        }

        if (!filter_var($_GET['url'], FILTER_VALIDATE_URL) || !self::isValidDomain($_GET['url'])) {
            die('Not a valid URL');
        }

    }

    static private function getFileName(): string {
        $filename = 'tiktok-video';
        if (isset($_GET['user'])) {
            $filename .= '-' . $_GET['user'] . '-' . $_GET['id'];
        }
        return $filename;
    }

    static public function stream() {
        self::checkUrl();
        $url = $_GET['url'];
        $streamer = new \TikScraper\Stream();
        $streamer->url($url);
    }

    static public function download() {
        $downloader = new \TikScraper\Download();
        $watermark = isset($_GET['watermark']);
        if ($watermark) {
            self::checkUrl();
            $filename = self::getFileName();
            $downloader->url($_GET['url'], $filename, true);
        } else {
            if (!isset($_GET['id'])) {
                die('You need to send an ID!');
            }
            $filename = self::getFileName();
            $downloader->url($_GET['id'], $filename, false);
        }
    }
}
