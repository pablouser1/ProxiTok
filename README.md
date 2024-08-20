# ProxiTok
Use Tiktok with an alternative frontend, inspired by Nitter.

## WARNING
THE LATEST VERSION **v2.5.0.0** INCLUDES BREAKING CHANGES, CHECK THE [PULL REQUEST](https://github.com/pablouser1/ProxiTok/pull/224) FOR MORE INFO

## Features
* Privacy: All requests made to TikTok are server-side, so you will never connect to their servers
* See user's feed
* See tags
* See video by id
* Themes
* RSS Feed for user and tag (just add /rss to the url)

## Self-hosting
Please check [this](https://github.com/pablouser1/ProxiTok/wiki/Self-hosting) wiki article for info on how to self-host your own instance

## Public instances
[This](https://github.com/pablouser1/ProxiTok/wiki/Public-instances) wiki article contains a list with all the known public instances.

Instances list in JSON format can be found in [instances.json](instances.json) file.

## Extensions
If you want to automatically redirect Tiktok links to ProxiTok you can use:
* [Libredirect](https://github.com/libredirect/libredirect)
* [Redirector](https://github.com/einaregilsson/Redirector)

You can use the following config if you want to use Redirector (you can change https://proxitok.pabloferreiro.es with whatever instance you want to use):
```
Description: TikTok to ProxiTok
Example URL: https://www.tiktok.com/@tiktok
Include pattern: (.*//.*)(tiktok.com)(.*)
Redirect to: https://proxitok.pabloferreiro.es$3
Example result: https://proxitok.pabloferreiro.es/@tiktok
Pattern type: Regular Expression
Apply to: Main window (address bar)
```

## TODO / Known issues
* Fix Heroku, still using old signer method
* Replace placeholder favicon
* Make video on /video fit screen and don't overflow
* Fix embed styling
* Fix crash when invalid vm.tiktok.com/CODE or www.tiktok.com/t/CODE is provided
* Add custom amount of videos per page

## Credits
* [TheFrenchGhosty](https://thefrenchghosty.me) ([Github](https://github.com/TheFrenchGhosty)): Initial Dockerfile and fixes to a usable state.
* [Jennifer Wjertzoch](https://wjertzochjennifer.medium.com): Carousel CSS Implementation

### External libraries
* [TikScraperPHP](https://github.com/pablouser1/TikScraperPHP)
* [Latte](https://github.com/nette/latte)
* [bramus/router](https://github.com/bramus/router)
* [PHP dotenv](https://github.com/vlucas/phpdotenv)
* [Bulma](https://github.com/jgthms/bulma) and [Bulmaswatch](https://github.com/jenil/bulmaswatch)
