# SPDY PHP

![Static Analysis](https://github.com/nickstarlight/php-spdy/actions/workflows/github-actions-static-analysis.yml/badge.svg)
![PHP Version](https://img.shields.io/badge/PHP%20Version-8.1-informational)
![Coding Style](https://img.shields.io/badge/Coding%20Style-PSR--12-yellow)
[![License: WTFPL](https://img.shields.io/badge/License-WTFPL-brightgreen.svg)](http://www.wtfpl.net/about/)

## About

Spdy PHP is an opinionated amalgamation of libraries for creating blazing fast, reliable and modern REST API's with PHP using RoadRunner.

By using sane industry standard defaults, Spdy lets you focus on your application business value, instead of wasting cycles choosing and re-choosing various technologies and configurations.

On the most high level definition, Spdy is just implementing battle tested, industry standard libraries for PHP and bundling it together to form a fast and reliable skeleton for your REST API's.

## Getting Stared

1. Install Spdy

```shell
composer require nickstarlight/spdy
```

2. Implement your application basic structure:

```php
<?php declare(strict_types=1);

include_once './vendor/autoload.php';

/** Create a new app instance */
$app = new Nickstarlight\Spdy\App();

/** Get the default router instance */
$router = $app->getRouter();

/** Declare a route */
$router->get('/', fn () => [ 'message' => 'Hello World' ]);

/** Kickstart the event-loop */
$app->run();
```

3. Get the RoadRunner binary:

```shell
./vendor/bin/rr get-binary
```

4. Implement a basic Roadrunner PHP Worker configuration, create a new file named `.rr.yaml` with the following contents:

```yaml
version: "2.7"

server:
  command: "php yourscript.php"

http:
  address: 0.0.0.0:8080
```

4. Start your application using the rr binary:

```bash
./rr serve
```

And you're good to go! Hit localhost:8080 and check your new route!

## Documentation reference

As mentioned, Spdy does not try to reinvent the wheel, all libraries used are well known libraries, if you'd like to tweak anything or change the provided defaults, the bellow documentation is all you need:

| Module                | Functions                                                      | What is used for?                                                                                                  | Documentation                       |
| --------------------- | -------------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------ | ----------------------------------- |
| PHP League Router 5.x | Router                                                         | Route declaration, HTTP error handling, JSON encoding, Route resolution and response strategy                      | https://route.thephpleague.com/5.x/ |
| Nyholm PSR-7 1.5.x    | Response and Request factories                                 | Parsing incomming requests and generating outgoing responses                                                       | https://github.com/Nyholm/psr7      |
| Roadrunner 2.x        | PHP Event Loop, HTTP Server, Load balancer and process manager | Creates blazing fast PHP Workers, acts as a replacement for Nginx and Apache and controls the lifecycle of workers | https://roadrunner.dev/docs         |

## FAQS

1. How do I declare routes?

   Check the [League Route documentation](https://route.thephpleague.com/5.x/routes/) for examples.

2. How do I configure the worker to fit my server needs? How do I setup healthchecks? Database connections? Environment variables?

   Roadrunner provides production-ready out-of-the-box configurations for those questions and many other features, check the [Roadrunner configuration file reference](https://roadrunner.dev/docs/intro-config/2.x/en).

3. I would like a robust ORM, broadcasting, views, integration with ReactJS/Vue/Svelte, etc...

   Spdy main goal is to provide a reliable, small and effient base for creating simple yet powerful REST API's, it does not attempt to replace complete frameworks.
   If you need more features, you should defintely aim for fully-fledged frameworks! Some good examples are [Symfony](https://symfony.com), [Laravel](https://laravel.com), [Yii](https://www.yiiframework.com), [Laminas](https://getlaminas.org) and [Phalcon](https://phalcon.io/en-us).

## Benchmarks
Check the [benchmarks](https://github.com/NickStarlight/php-spdy-benchmarks) standalone repository for more information.

|                                              | PHP 8.1 - Spdy                                                                                                                                        | C++ 17 - uWebsockets                                                                                                                                         | Go 1.18 - Gin                                                                                                                                                   | Python 3.9 - FastAPI                                                                                                                                           | NodeJS 16 - Fastify                                                                                                                                             |
|----------------------------------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------|
| Time taken for tests                         | 57.129 seconds                                                                                                                                        | 9.208 seconds                                                                                                                                                | 14.929 seconds                                                                                                                                                  | 90.420 seconds                                                                                                                                                 | 18.484 seconds                                                                                                                                                  |
| Complete requests                            | 100000                                                                                                                                                | 100000                                                                                                                                                       | 100000                                                                                                                                                          | 100000                                                                                                                                                         | 100000                                                                                                                                                          |
| Failed requests                              | 0                                                                                                                                                     | 0                                                                                                                                                            | 0                                                                                                                                                               | 0                                                                                                                                                              | 0                                                                                                                                                               |
| Requests per second (mean)                   | 1750.41                                                                                                                                               | 10859.95                                                                                                                                                     | 6698.22                                                                                                                                                         | 1105.94                                                                                                                                                        | 5410.07                                                                                                                                                         |
| Time per request (mean)                      | 57.129 [ms]                                                                                                                                           | 9.208 [ms]                                                                                                                                                   | 14.929 [ms]                                                                                                                                                     | 90.420 [ms]                                                                                                                                                    | 18.484 [ms]                                                                                                                                                     |
| Transfer rate                                | 241.02 [Kbytes/sec]                                                                                                                                   | 901.46 [Kbytes/sec]                                                                                                                                          | 974.64 [Kbytes/sec]                                                                                                                                             | 183.60 [Kbytes/sec]                                                                                                                                            | 887.59 [Kbytes/sec]                                                                                                                                             |
| Percentage of requests served in miliseconds | 50%     57 <br> 66%     58 <br>75%     59 <br>80%     60 <br>90%     61 <br>95%     63 <br>98%     65 <br>99%     66 <br>100%    82 (longest request) | 50%      9 <br> 66%     10 <br> 75%     11 <br> 80%     12 <br> 90%     13 <br> 95%     14 <br> 98%     16 <br> 99%     18 <br> 100%    77 (longest request) | 50%      14 <br> 66%      16 <br>75%      18 <br> 80%      19 <br>90%      22 <br>95%      25 <br>98%      28 <br>99%      30 <br>100%     68 (longest request) | 50%      88 <br> 66%      91 <br>75%      93 <br>80%      95 <br>90%     101 <br>95%     105 <br>98%     110 <br>99%     113 <br>100%    162 (longest request) | 50%      19 <br> 66%      20 <br> 75%      20 <br>80%      21 <br>90%      23 <br>95%      26 <br>98%      30 <br>99%      33 <br>100%     55 (longest request) |

## License

This work is licensed under the [WTFPL](https://choosealicense.com/licenses/wtfpl/) license.
