<?php
namespace Views\Models;

/**
* Base for templates with item (only /video at the time)
*/
class ItemTemplate extends BaseTemplate {
    public object $item;

    function __construct(string $title, object $item) {
        parent::__construct($title);
        $this->item = $item;
    }
}
