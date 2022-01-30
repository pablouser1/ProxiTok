# ProxiTok
Use Tiktok with an alternative frontend, inspired by Nitter.

## Features
* Privacy: All requests made to TikTok are server-side, so you will never connect to their servers
* See user's feed
* See trending
* See tags
* See video by id
* Create a following list, which you can later use to see all the feeds from those users
* RSS Feed for user, trending and tag (just add /rss to the url)

## Installation
Clone the repository and fetch the requiered external packages with:
```bash
composer install
```

WARNING: You'll need a personal Github token for composer.

Then you can run it using for example the PHP Development Server with:
```bash
php -S localhost:8080
```

## Configuration
### .env
Move the .env.example file to .env and modify it.

### Cache engines
Available cache engines:
* redis: Writes response to Redis
* json: Writes response to JSON file

### Apache
You don't have to do anything more

### Nginx
Add the following to your config (you can modify the proxitok part if you have or not a subdir):
```
location /proxitok {
    return 302 $scheme://$host/proxitok/;
}

location /proxitok/ {
    try_files $uri $uri/ /proxitok/index.php?$query_string;
}

location /proxitok/.env {
    deny all;
    return 404;
}
```

## TODO
* Add a NoJS version / Make the whole program without required JS
* Better error handling
* Make video on /video fit screen and don't overflow

## Credits
* [TikTok-API-PHP](https://github.com/ssovit/TikTok-API-PHP) (Currently using my personal fork)
* [bramus/router](https://github.com/bramus/router)
* [PHP dotenv](https://github.com/vlucas/phpdotenv)
* [Bulma](https://github.com/jgthms/bulma) and [Bulmaswatch](https://github.com/jenil/bulmaswatch)
* [FeedWriter](https://github.com/mibe/FeedWriter)
