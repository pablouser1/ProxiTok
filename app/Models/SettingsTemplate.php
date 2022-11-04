<?php
namespace App\Models;

use App\Constants\Themes;
use App\Helpers\Cookies;
use TikScraper\Constants\DownloadMethods;

/**
 * Settings model with all possible config items
 */
class SettingsTemplate extends BaseTemplate {
    public array $downloaders = [];
    public array $themes = [];
    public bool $isTestEndpoints = false;
    public string $currentDownloader;
    public string $currentTheme;
    public bool $isServiceWorker = false;

    function __construct() {
        parent::__construct("Settings");
        // Downloaders list
        $ref = new \ReflectionClass(DownloadMethods::class);
        $this->downloaders = $ref->getConstants();
        // Themes list
        $ref = new \ReflectionClass(Themes::class);
        $this->themes = $ref->getConstants();
        // Cookies data
        $this->isTestEndpoints = Cookies::check('api-test_endpoints', 'yes');
        $this->currentDownloader = Cookies::downloader();
        $this->currentTheme = Cookies::theme();
        $this->isServiceWorker = Cookies::check('misc-sw', 'yes');
    }
}
