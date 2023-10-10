<?php
namespace App\Models;

class RSSTemplate extends BaseTemplate {
    public string $desc;
    public string $image;
    public string $link;
    public array $items;

    function __construct(string $title, string $desc, string $image, string $link, array $items) {
        parent::__construct($title);
        $this->desc = $desc;
        $this->image = $image;
        $this->link = $link;
        $this->items = $items;
    }
}
