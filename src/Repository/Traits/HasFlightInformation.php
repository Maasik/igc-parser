<?php

namespace Theomessin\IGCParser\Repository\Traits;

trait HasFlightInformation
{
    protected $date;
    protected $pilotInCommand;
    protected $gliderType;
    protected $gliderId;

    public function getDate()
    {
        return $this->date;
    }

    public function getPilotInCommand()
    {
        return $this->pilotInCommand;
    }

    public function getGliderType()
    {
        return $this->gliderType;
    }

    public function getGliderId()
    {
        return $this->gliderId;
    }

    public function getLateralTrace()
    {
        return $this->fixes->filter(function($value, $key) {
            return $key % 10 === 0;
        })->map->coordinates->values();
    }

    public function getVerticalTrace()
    {
        return $this->fixes->filter(function($value, $key) {
            return $key % 10 === 0;
        })->map(function($e) {
            return [
                'time' => $e->time,
                'height' => $e->height,
            ];
        })->values();
    }
}