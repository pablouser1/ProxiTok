<?php
namespace App\Controllers;
use App\Helpers\Misc;

/**
 * Used to be compatible with HTML forms
 */
class RedirectController {
    static public function redirect() {
        $endpoint = '/';
        if (isset($_GET['type'], $_GET['term'])) {
            $term = trim($_GET['term']);
            switch ($_GET['type']) {
                case 'user':
                    // Remove @ if sent
                    if ($term[0] === '@') {
                        $term = substr($term, 1);
                    }
                    $endpoint = '/@' . $term;
                    break;
                case 'tag':
                    // Remove # if sent
                    if ($term[0] === '#') {
                        $term = substr($term, 1);
                    }
                    $endpoint = '/tag/' . $term;
                    break;
                case 'music':
                    $endpoint = '/music/' . $term;
                    break;
                case 'video':
                    // The @username part is not used, but
                    // it is the schema that TikTok follows
                    $endpoint = '/@placeholder/video/' . $term;
                    break;
                }
        }

        $url = Misc::url($endpoint);
        header("Location: {$url}");
    }
}
