<?php

namespace Theomessin\IGCParser\Contracts;

use Illuminate\Contracts\Foundation\Application as App;

interface Parser
{
    /**
     * Instantiate a new Parser object.
     *
     * @param \Illuminate\Contracts\Foundation\Application app
     */
    public function __construct(App $app);

    /**
     * Load and parse an IGC flight data file.
     *
     * @param string $path
     * @return \Theomessin\IGCParser\Contracts\Flightdata
     *
     * @throws \Theomessin\IGCParser\Contracts\FileNotFoundException
     */
    public function load($path);
}