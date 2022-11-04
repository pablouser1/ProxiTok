<?php
namespace App\Models;

class RSSTemplate extends BaseTemplate {
    public string $desc;
    public string $link;
    public array $items;

    function __construct(string $title, string $desc, string $link, array $items) {
        parent::__construct($title);
        $this->desc = $desc;
        $this->link = $link;
        $this->items = $items;
    }
}
