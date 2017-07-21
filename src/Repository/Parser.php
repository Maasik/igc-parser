<?php

namespace Theomessin\IGCParser\Repository;

use Illuminate\Contracts\Foundation\Application as App;
use Theomessin\IGCParser\Contracts\Parser as ParserContract;

class Parser implements ParserContract
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application $app
     */
    protected $app;

    /**
     * Instantiate a new Parser object.
     *
     * @param \Illuminate\Contracts\Foundation\Application app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Load and parse an IGC flight data file.
     *
     * @param string $path
     * @return \Theomessin\IGCParser\Contracts\Flightdata
     *
     * @throws \Theomessin\IGCParser\Contracts\FileNotFoundException
     */
    public function load($path)
    {
        return $this->app->makeWith(Flightdata::class, compact('path'));
    }
}