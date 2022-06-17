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

Method: ab -k -n 500000 -c 100 localhost:{DEFAULT_PORT}/

Machine: Debian 10(Buster) 16 GB RAM, 4 vCPUs, 320 GB SSD (AWS Lighsail)

Number of workers: 4(Equal to vCPUs)

Rules:

- Two runs - One for warmup, one for benchmark.
- Fresh instance with optimized scenarios for each framework/language.

|                                              | PHP Spdy                                                                                                           | NodeJS 16 - Fastify                                                                                               |
| -------------------------------------------- | ------------------------------------------------------------------------------------------------------------------ | ----------------------------------------------------------------------------------------------------------------- |
| Time taken for tests                         | 30.650 seconds                                                                                                     | 10.603 seconds                                                                                                    |
| Complete requests                            | 500000                                                                                                             | 500000                                                                                                            |
| Failed requests                              | 0                                                                                                                  | 0                                                                                                                 |
| Requests per second (mean)                   | 16313.09                                                                                                           | 47154.76                                                                                                          |
| Time per request (mean)                      | 6.130 ms                                                                                                           | 2.121 ms                                                                                                          |
| Transfer rate                                | 2612.64 Kbytes/sec                                                                                                 | 8657.32 Kbytes/sec                                                                                                |
| Percentage of requests served in miliseconds | 50% 6 <br> 66% 6 <br> 75% 6 <br> 80% 6 <br> 90% 7 <br> 95% 8 <br> 98% 9 <br> 99% 10 <br> 100% 31 (longest request) | 50% 2 <br> 66% 2 <br> 75% 3 <br> 80% 3 <br> 90% 3 <br> 95% 4 <br> 98% 5 <br> 99% 8 <br> 100% 63 (longest request) |

## License

This work is licensed under the [WTFPL](https://choosealicense.com/licenses/wtfpl/) license.
