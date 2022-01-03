<?php
if (!file_exists(__DIR__ . '/.new_api')) {
    $new_api = file_get_contents('https://raw.githubusercontent.com/attend-dunce/TikTok-API-PHP/master/lib/TikTok/Api.php');
    file_put_contents(__DIR__ . '/vendor/ssovit/tiktok-api/lib/TikTok/Api.php', $new_api);
    file_put_contents(__DIR__ .  '/.new_api', 'DO NOT DELETE! This file proves that you have patched the API');
    echo('Patched API!');
}
