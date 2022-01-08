# TikTok alternative Frontend
Use Tiktok using an alternative frontend, inspired by Nitter.

## Features
* Privacy: All requests made to TikTok are server-side, so you will never connect to TikTok servers
* See user's feed
* See trending
* See tags
* See video by id
* Create a following list, which you can later use to see all the feeds from those users

## Installation
Clone the repository and fetch the requiered external packages with:
```bash
composer install
```

Then you can run it using for example the PHP Development Server with:
```bash
php -S localhost:8080
```

## Configuration
### .env
Move the .env.example file to .env and modify it.

### Apache
You don't have to do anything more

### Nginx
Add the following to your config (you can modify the tiktok-viewer part if you have or not a subdir):
```
location /tiktok-viewer {
    return 302 $scheme://$host/tiktok-viewer/;
}

location /tiktok-viewer/ {
    try_files $uri $uri/ /tiktok-viewer/index.php?$query_string;
}

location /tiktok-viewer/.env {
    deny all;
    return 404;
}
```

## Known issues
* Fetching a user fails, there is already a pull request not merged yet fixing this issue on the TikTokApi repo, you can check it out [here](https://github.com/ssovit/TikTok-API-PHP/pull/43).
* Fetching a video by id or by url fails
**These issues are automatically patched after running composer install**

## TODO
* Add a NoJS version / Make the whole program without required JS
* Better error handling
* Make video on /video fit screen and don't overflow

## Credits
* [TikTok-API-PHP](https://github.com/ssovit/TikTok-API-PHP)
* [steampixel/simple-php-router](https://github.com/steampixel/simple-php-router)
* [PHP dotenv](https://github.com/vlucas/phpdotenv)
* [Bulma](https://github.com/jgthms/bulma)
* [Bulmaswatch](https://github.com/jenil/bulmaswatch)
