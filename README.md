# ProxiTok
Use Tiktok with an alternative frontend, inspired by Nitter.

## Features
* Privacy: All requests made to TikTok are server-side, so you will never connect to their servers
* See user's feed
* See trending
* See tags
* See video by id
* Discovery
* RSS Feed for user, trending and tag (just add /rss to the url)

## Extension 
If you want to automatically redirect Tiktok links to ProxiTok you can use:
* [Libredirect](https://github.com/libredirect/libredirect)
* [Redirector](https://github.com/einaregilsson/Redirector)

You can use the following config if you want to use Redirector (you can change https://proxitok.herokuapp.com with whatever instance you want to use):
```
Description: TikTok to ProxiTok
Example URL: https://www.tiktok.com/@tiktok
Include pattern: (.*//.*)(tiktok.com)(.*)
Redirect to: https://proxitok.herokuapp.com$3
Example result: https://proxitok.herokuapp.com/@tiktok
Pattern type: Regular Expression
Apply to: Main window (address bar)
```

## Installation
Clone the repository and fetch the requiered external packages with:
```bash
composer install
```

WARNING: You'll need a personal Github token for composer.

Then you can run it using for example the PHP Development Server with:
```bash
php -S localhost:8080 -t public
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
* i18n

## Credits
* [TikTok-API-PHP](https://github.com/ssovit/TikTok-API-PHP) (Currently using my personal fork)
* [Latte](https://github.com/nette/latte)
* [bramus/router](https://github.com/bramus/router)
* [PHP dotenv](https://github.com/vlucas/phpdotenv)
* [Bulma](https://github.com/jgthms/bulma) and [Bulmaswatch](https://github.com/jenil/bulmaswatch)
* [FeedWriter](https://github.com/mibe/FeedWriter)
