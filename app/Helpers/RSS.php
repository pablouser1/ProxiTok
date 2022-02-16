<?php
namespace App\Helpers;

use \FeedWriter\RSS2;
use \Sovit\TikTok\Download;

class RSS {
    static public function build(string $endpoint, string $title, string $description, array $items): string {
        $url = Misc::env('APP_URL', '');
        $download = new Download();
        $rss = new RSS2();
        $rss->setTitle($title);
        $rss->setDescription($description);
        $rss->setLink($url . $endpoint);
        $rss->setSelfLink($url . $endpoint . '/rss');
        foreach ($items as $item) {
            $item_rss = $rss->createNewItem();
            $video = $item->video->playAddr;
            $item_rss->setTitle($item->desc);
            $item_rss->setDescription($item->desc);
            $item_rss->setLink($url . '/video/' . $item->id);
            $item_rss->setDate((int) $item->createTime);
            $item_rss->setId($item->id, false);
            $item_rss->addEnclosure($url . '/stream?url=' . urlencode($video), $download->file_size($video), 'video/mp4');
            $rss->addItem($item_rss);
        }
        return $rss->generateFeed();
    }

    static public function setHeaders (string $filename) {
        header('Content-Type: application/rss+xml');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
    }
}
