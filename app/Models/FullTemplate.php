<?php
namespace App\Models;

use TikScraper\Models\Feed;
use TikScraper\Models\Info;

/**
* Base for templates with both info and feed
*/
class FullTemplate extends BaseTemplate {
    public Info $info;
    public Feed $feed;

    function __construct(string $title, Info $info, Feed $feed) {
        parent::__construct($title);
        $this->info = $info;
        $this->feed = $feed;
    }
}
