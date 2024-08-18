<?php
namespace App\Controllers;
use App\Helpers\ErrorHandler;
use App\Helpers\Misc;
use App\Helpers\UrlBuilder;

/**
 * Used to be compatible with HTML forms
 */
class RedirectController {
    public static function search() {
        $endpoint = '/';
        if (isset($_GET['type'], $_GET['term'])) {
            $term = trim($_GET['term']);
            switch ($_GET['type']) {
                case 'url':
                    $endpoint = self::to_endpoint($term);
                    if (!$endpoint) {
                        ErrorHandler::showText(400, 'Invalid TikTok URL');
                        return;
                    }
                    break;
                case 'user':
                    // Remove @ if sent
                    if ($term[0] === '@') {
                        $term = substr($term, 1);
                    }
                    $endpoint = '/@' . urlencode($term);
                    break;
                case 'tag':
                    // Remove # if sent
                    if ($term[0] === '#') {
                        $term = substr($term, 1);
                    }
                    $endpoint = '/tag/' . urlencode($term);
                    break;
                case 'music':
                    $endpoint = '/music/' . urlencode($term);
                    break;
                case 'video':
                    // The @username part is not used, but
                    // it is the schema that TikTok follows
                    $endpoint = '/@placeholder/video/' . urlencode($term);
                    break;
                }
        }

        $url = Misc::url($endpoint);
        header("Location: {$url}");
    }

    public static function download() {
        if (!(isset($_GET['videoId'], $_GET['authorUsername'], $_GET['playAddr']))) {
            ErrorHandler::showText(400, 'Request incomplete');
            return;
        }

        $watermark = isset($_GET['watermark']) && $_GET['watermark'] === 'yes' ? true : false;

        $url = '';
        if ($watermark) {
            $url = UrlBuilder::download($_GET['playAddr'], $_GET['authorUsername'], $_GET['videoId'], true);
        } else {
            $url = UrlBuilder::download(UrlBuilder::video_external($_GET['authorUsername'], $_GET['videoId']), $_GET['authorUsername'], $_GET['videoId'], false);
        }

        header("Location: {$url}");
    }

    /**
     * to_endpoint maps a TikTok URL into a ProxiTok-compatible endpoint URL.
     */
    static private function to_endpoint(string $url): string {
        if (preg_match('%^(?:https?://)?(?:www\.)?(?:vm\.|vt\.|lite\.)?tiktok\.com/(?:t/)?([A-Za-z0-9]+)%', $url, $m)) {
            // Short video URL
            return '/@placeholder/video/' . $m[1];
        } elseif (preg_match('%^https://www\.tiktok\.com/(.+)%', $url, $m)) {
            // Username component (which may indicate a user profile URL or a video URL)
            if (preg_match('%^(@[A-Za-z0-9_.]+)(?:/|$)(.*)%', $m[1], $u)) {
                if ($u[2] == '') {
                    // User profile URL
                    return '/' . urlencode($u[1]);
                } elseif (preg_match('%^video/(\d+)%', $u[2], $v)) {
                    // Video URL
                    return '/' . urlencode($u[1]) . '/video/' . urlencode($v[1]);
                }
            } elseif (preg_match('%^tag/([^ ]+?)(?:/|$)%', $m[1], $t)) {
                // Tag URL
                return '/tag/' . urlencode($t[1]);
            } elseif (preg_match('%^music/([^ ]+?)(?:/|$)%', $m[1], $m)) {
                // Music URL
                return '/music/' . urlencode($m[1]);
            }
        }

        return '';
    }
}
