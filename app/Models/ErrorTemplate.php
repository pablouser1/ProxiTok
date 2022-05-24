<?php
namespace App\Models;

use TikScraper\Models\Meta;

class ErrorTemplate extends BaseTemplate {
    public Meta $error;

    function __construct(object $error) {
        parent::__construct('Error');
        $this->error = $error;
    }
}
