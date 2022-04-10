<?php
namespace App\Models;

/**
* Base for templates with a feed
*/
class VideoTemplate extends BaseTemplate {
    public object $item;
    public object $detail;
    public string $layout = 'hero';

    function __construct(object $item, object $detail, bool $isEmbed = false) {
        parent::__construct('Video');
        $this->item = $item;
        $this->detail = $detail;
        if ($isEmbed) {
            $this->layout = 'embed';
        } else {
            $this->layout = 'hero';
        }
    }
}
