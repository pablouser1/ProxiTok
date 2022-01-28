<?php
namespace Helpers;

use \Bhaktaraz\RSSGenerator\Feed;
use \Bhaktaraz\RSSGenerator\Channel;
use \Bhaktaraz\RSSGenerator\Item;
use \Sovit\TikTok\Download;

class RSS {
    static public function build (string $endpoint, string $title, string $description, array $items, string $image = ''): Feed {
        $url = Misc::env('APP_URL', '');
        $download = new Download();
        $rss_feed = new Feed();
        $rss_channel = new Channel();
        $rss_channel
            ->title($title)
            ->description($description)
            ->url($url . $endpoint)
            ->atomLinkSelf($url . $endpoint . '/rss')
            ->appendTo($rss_feed);
        foreach ($items as $item) {
            $rss_item = new Item();
            $video = $item->video->playAddr;
            $rss_item
                ->title($item->desc)
                ->description($item->desc)
                ->url($url . '/video/' . $item->id)
                ->pubDate((int)$item->createTime)
                ->guid($item->id, false)
                ->enclosure($url . '/stream?url=' . urlencode($video), $download->file_size($video), 'video/mp4')
                ->appendTo($rss_channel);
        }
        return $rss_feed;
    }

    static public function setHeaders (string $filename) {
        header('Content-Type: application/rss+xml');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
    }
}
