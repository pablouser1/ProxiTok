<?php
namespace App\Helpers;

class UrlBuilder {
    static public function stream(string $url): string {
        return Misc::url('/stream?url=' . urlencode($url));
    }

    static public function download(string $url, string $username, string $id, bool $watermark): string {
        $down_url = Misc::url('/download?url=' . urlencode($url) . '&id=' . $id . '&user=' . $username);
        if ($watermark) $down_url .= '&watermark=1';
        return $down_url;
    }

    static public function user(string $username): string {
        return Misc::url('/@' . $username);
    }

    static public function tag(string $tag): string {
        return Misc::url('/tag/' . $tag);
    }

    static public function video_internal(string $username, string $id): string {
        return Misc::url('/@' . $username . "/video/" . $id);
    }

    static public function video_external(string $username, string $id): string {
        return "https://www.tiktok.com/@" . $username . "/video/" . $id;
    }
}
