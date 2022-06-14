<?php

declare(strict_types=1);

namespace Nickstarlight\Spdy;

use League\Route\Router as LeagueRouter;
use Nickstarlight\Spdy\Router\RouterContainer;
use Nickstarlight\Spdy\Worker\WorkerContainer;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

/**
 * The main Spdy App instance.
 *
 * This class initializes Roadrunner and creates attaches the router,
 * creating your REST application skeleton.
 */
class App
{
    /**
     * The Worker container used by Spdy.
     *
     * @var WorkerContainer
     */
    private WorkerContainer $workerContainer;

    /**
     * The Router container used by Spdy.
     *
     * @var RouterContainer
     */
    private RouterContainer $routerContainer;

    public function __construct()
    {
        $this->createDefaultRouter();
        $this->createDefaultWorker();
    }

    /**
     * Creates the default Router instace used by Spdy.
     *
     * By default, Spdy sets sane defaults for a production
     * ready Router.
     *
     * @return void
     */
    private function createDefaultRouter(): void
    {
        $this->routerContainer = new RouterContainer();
    }

    /**
     * Creates the default Worker instance used by Spdy.
     *
     * By default, Spdy set sane defaults for a production
     * ready RoadRunner worker.
     *
     * @return void
     */
    private function createDefaultWorker(): void
    {
        $this->workerContainer = new WorkerContainer();
    }

    /**
     * Returns the current Worker container.
     *
     * @return WorkerContainer
     */
    public function getWorkerContainer(): WorkerContainer
    {
        return $this->workerContainer;
    }

    /**
     * Replaces the current Worker container.
     *
     * @param WorkerContainer $workerContainer
     * @return App
     */
    public function setWorkerContainer(WorkerContainer $workerContainer): self
    {
        $this->workerContainer = $workerContainer;
        return $this;
    }

    /**
     * Returns the current Router container.
     *
     * @return RouterContainer
     */
    public function getRouterContainer(): RouterContainer
    {
        return $this->routerContainer;
    }

    /**
     * Replaces the current Router container.
     *
     * @param RouterContainer $routerContainer
     * @return App
     */
    public function setRouterContainer(RouterContainer $routerContainer): self
    {
        $this->routerContainer = $routerContainer;
        return $this;
    }

    /**
     * Returns the `League\Route\Router` instance.
     *
     * This is the method used to return the actual Router implementation
     * that allows creating routes.
     *
     * @return LeagueRouter
     */
    public function getRouter(): LeagueRouter
    {
        return $this->routerContainer->getRouter();
    }

    /**
     * Starts the `RoadRunner` workers and creates the app event loop.
     */
    public function run(): void
    {
        $worker = $this->workerContainer->getRoadRunnerHTTPWorker();
        $router = $this->routerContainer->getRouter();

        while (true) {
            try {
                $request = $worker->waitRequest();

                if (!($request instanceof ServerRequestInterface)) {
                    break;
                }
            } catch (Throwable) {
                /** RoadRunner received a malformed HTTP request */
                $worker->respond(new Response(status: 400));

                continue;
            }

            try {
                $response = $router->dispatch(request: $request);
                $worker->respond(response: $response);
            } catch (Throwable) {
                $worker->respond(new Response(status: 500));
            }
        }
    }
}
