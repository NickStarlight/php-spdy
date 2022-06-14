<?php

declare(strict_types=1);

namespace Nickstarlight\Spdy\ResponseStrategy;

use League\Route\Strategy\JsonStrategy;
use Nyholm\Psr7\Factory\Psr17Factory;

/**
 * Creates a `League\Route\Router` JSON response strategy.
 *
 * This class extends `League\Route\Strategy\JsonStrategy` to provide
 * and easier abstraction for automatically creating the strategy with
 * a PSR-17 Response Factory.
 *
 * @see https://route.thephpleague.com/5.x/strategies/
 */
class JsonResponseStrategy extends JsonStrategy
{
    /**
     * Creates the JsonStrategy response.
     *
     * @return JsonResponseStrategy
     */
    public function __construct()
    {
        $responseFactory = new Psr17Factory();
        $jsonFlags = JSON_PRETTY_PRINT;

        parent::__construct(
            responseFactory: $responseFactory,
            jsonFlags: $jsonFlags
        );
    }
}
