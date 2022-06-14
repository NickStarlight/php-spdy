<?php

declare(strict_types=1);

namespace Nickstarlight\Spdy\Router;

use League\Route\Router as LeagueRouter;
use Nickstarlight\Spdy\ResponseStrategy\JsonResponseStrategy;

/**
 * Defines an easy abstraction of the Router with sane production defaults.
 *
 * This class performs the following:
 * 1. Creates a new `League\Route\Router` instance.
 * 2. Sets the `League\Route\Router` response strategy as JSON.
 */
class RouterContainer
{
    /**
     * The `League\Route\Router` instance.
     *
     * @var LeagueRouter
     * @see https://route.thephpleague.com/5.x/usage/
     */
    private LeagueRouter $router;

    /**
     * Creates the Router instance.
     *
     * @return RouterContainer
     */
    public function __construct()
    {
        $this->router = new LeagueRouter();
        $this->router->setStrategy(new JsonResponseStrategy());
    }

    /**
     * Returns the current `League\Route\Router` instance.
     *
     * @return LeagueRouter
     */
    public function getRouter(): LeagueRouter
    {
        return $this->router;
    }

    /**
     * Replaces the default `League\Route\Router` instance.
     *
     * @param LeagueRouter $router
     * @return RouterContainer
     */
    public function setRouter(LeagueRouter $router): self
    {
        $this->router = $router;

        return $this;
    }
}
