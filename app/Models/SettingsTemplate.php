<?php
namespace App\Models;

use App\Helpers\Cookies;
use App\Helpers\Following;

/**
* Exclusive for /settings
*/
class SettingsTemplate extends BaseTemplate {
    public array $proxy_elements = [];
    public array $following = [];

    function __construct() {
        parent::__construct('Settings');
        $this->proxy_elements = Cookies::PROXY;
        $this->following = Following::getUsers();
    }
}
