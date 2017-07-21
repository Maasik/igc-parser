<?php

namespace Theomessin\IGCParser\Contracts;

use Illuminate\Contracts\Filesystem\Filesystem as File;

interface Flightdata
{
    /**
     * Flightdata constructor.
     *
     * @param \Illuminate\Contracts\Filesystem\Filesystem $file
     * @param string $path
     *
     * @throws \Theomessin\IGCParser\Contracts\FileNotFoundException
     */
    public function __construct(File $file, $path);

    /**
     * Flight Data Information Accessors
     */
    public function getDate();
    public function getPilotInCommand();
    public function getGliderType();
    public function getGliderId();
}