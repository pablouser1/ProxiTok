<?php
namespace Helpers;

class Error {
    const list = [
        'api' => [
            'code' => 500,
            'message' => 'API unknown error, please check back later'
        ],
        'latte' => [
            'code' => 500,
            'message' => 'Template render crash, please check back later'
        ]
    ];

    static public function show(string $type) {
        $keys = array_keys(self::list);
        if (in_array($type, $keys)) {
            $error = self::list[$type];
            http_response_code($error['code']);
            $latte = Misc::latte();
            $latte->render(Misc::getView('error'), ['type' => $type, 'error' => $error]);
        }
    }
}
