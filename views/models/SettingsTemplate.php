<?php
namespace Views\Models;

use \Helpers\Following;
use \Helpers\Settings;

/**
* Exclusive for /settings
*/
class SettingsTemplate extends BaseTemplate {
    public array $proxy_elements = [];
    public array $following = [];

    function __construct() {
        parent::__construct('Settings');
        $this->proxy_elements = Settings::PROXY;
        $this->following = Following::get();
    }
}
