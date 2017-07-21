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
}