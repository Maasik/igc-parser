<?php

namespace Theomessin\IGCParser\Repository\Records;

abstract class Record
{
    /**
     * Record constructor.
     * @param string $line
     */
    public function __construct($line)
    {
        $this->process($line);
    }

    abstract protected function process($line);
}