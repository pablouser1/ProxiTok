<?php
namespace App\Models;

class RSSTemplate {
    public string $title;
    public string $desc;
    public string $link;
    public array $items;

    function __construct(string $title, string $desc, string $link, array $items) {
        $this->title = $title;
        $this->desc = $desc;
        $this->link = $link;
        $this->items = $items;
    }
}
