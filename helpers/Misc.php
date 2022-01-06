<?php
namespace Helpers;
use Helpers\Settings;

class Misc {
    static public function getSubDir(): string {
        return isset($_ENV['APP_SUBDIR']) && !empty($_ENV['APP_SUBDIR']) ? $_ENV['APP_SUBDIR'] : '';
    }

    static public function getView(string $template): string {
        return __DIR__ . "/../views/{$template}.latte";
    }

    static public function api(): \Sovit\TikTok\Api {
        $options = [];
        // Proxy config
        if (in_array(Settings::PROXY, $_COOKIE)) {
            foreach (Settings::PROXY as $proxy_element) {
                $options[$proxy_element] = $_COOKIE[$proxy_element];
            }
        }
        $api = new \Sovit\TikTok\Api($options);
        return $api;
    }

    static public function latte(): \Latte\Engine {
        $subdir = Misc::getSubDir();
        $latte = new \Latte\Engine;
        $latte->setTempDirectory(__DIR__ . '/../cache/views');
        $latte->addFunction('assets', function (string $name, string $type)  use ($subdir) {
            $path = "{$subdir}/{$type}/{$name}";
            return $path;
        });
        $latte->addFunction('path', function (string $name) use ($subdir) {
            $path = "{$subdir}/{$name}";
            return $path;
        });
        // https://stackoverflow.com/a/36365553
        $latte->addFunction('number', function (int $x) {
            if($x > 1000) {
                $x_number_format = number_format($x);
                $x_array = explode(',', $x_number_format);
                $x_parts = array('K', 'M', 'B', 'T');
                $x_count_parts = count($x_array) - 1;
                $x_display = $x;
                $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
                $x_display .= $x_parts[$x_count_parts - 1];
                return $x_display;
            }
            return $x;
        });
        return $latte;
    }
}
