<?php
namespace App\Models;

use App\Helpers\Cookies;

/**
* Exclusive for /settings
*/
class SettingsTemplate extends BaseTemplate {
    public array $proxy_elements = [];

    function __construct() {
        parent::__construct('Settings');
        $this->proxy_elements = Cookies::PROXY;
    }
}
