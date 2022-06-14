<?php

declare(strict_types=1);

namespace Nickstarlight\Spdy\Worker;

use Nyholm\Psr7\Factory\Psr17Factory;
use Spiral\RoadRunner;
use Spiral\RoadRunner\Http\PSR7Worker;
use Spiral\RoadRunner\Worker as RoadRunnerWorker;

/**
 * Defines an easy abstraction of the RoadRunner worker boostraping with production sane defaults.
 *
 * This class performs the following:
 * 1. Creates the RoadRunner worker instance, responsible for interfacing PHP with RoadRunner.
 * 2. Creates the PSR17 response factory, used by RoadRunner to create the objects of incomming requests.
 * 3. Creates the RoadRunner HTTP Worker, responsible for listening, parsing and returning HTTP requests.
 */
class WorkerContainer
{
    /**
     * The RoadRunner HTTP worker instance.
     *
     * @var RoadRunner\Http\PSR7Worker
     * @see https://roadrunner.dev/docs/php-worker/2.x/en
     */
    private RoadRunner\Http\PSR7Worker $worker;

    /**
     * Creates the Spdy Worker instance.
     *
     * @return WorkerContainer
     */
    public function __construct()
    {
        $roadRunner = $this->createRoadRunnerWorker();
        $responseFactory = $this->createResponseFactory();
        $this->worker = $this->createRoadRunnerHttpWorker(
            roadRunnerWorker: $roadRunner,
            responseFactory: $responseFactory
        );
    }

    /**
     * Returns the current `RoadRunner\Http\PSR7Worker` instance.
     *
     * @return RoadRunner\Http\PSR7Worker
     */
    public function getRoadRunnerHTTPWorker(): PSR7Worker
    {
        return $this->worker;
    }

    /**
     * Replaces the default `RoadRunner\Http\PSR7Worker` instance.
     *
     * @param PSR7Worker $worker
     * @return WorkerContainer
     */
    public function setRoadRunnerHTTPWorker(PSR7Worker $worker): self
    {
        $this->worker = $worker;

        return $this;
    }

    /**
     * Creates the default RoadRunner worker.
     *
     * @return RoadRunnerWorker
     */
    private function createRoadRunnerWorker(): RoadRunnerWorker
    {
        return RoadRunner\Worker::create();
    }

    /**
     * Creates the default ResponseFactor.
     *
     * @return Psr17Factory
     */
    private function createResponseFactory(): Psr17Factory
    {
        return new Psr17Factory();
    }

    /**
     * Creates the default RoadRunner HTTP Worker.
     *
     * @param RoadRunnerWorker $roadRunnerWorker
     * @param Psr17Factory $responseFactory
     * @return PSR7Worker
     */
    private function createRoadRunnerHttpWorker(
        RoadRunnerWorker $roadRunnerWorker,
        Psr17Factory $responseFactory
    ): PSR7Worker {
        return new RoadRunner\Http\PSR7Worker(
            worker: $roadRunnerWorker,
            requestFactory: $responseFactory,
            streamFactory: $responseFactory,
            uploadsFactory: $responseFactory
        );
    }
}
