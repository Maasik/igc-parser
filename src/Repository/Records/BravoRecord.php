<?php

namespace Theomessin\IGCParser\Repository\Records;

use Carbon\Carbon;
use Theomessin\IGCParser\Repository\Helpers;
use Theomessin\IGCParser\Repository\Records\Record;
use Theomessin\IGCParser\Contracts\SpecificRecord as RecordContract;

class BravoRecord extends Record implements RecordContract
{
    public $time;
    public $coordinates;
    public $altitude; // Above QNH STD 1013.25 hPa
    public $height; // Above the WGS84 ellipsoid

    protected function process($line)
    {
        $this->time = $line[1] . $line[2] . ':' . $line[3] .  $line[4] .  ':' . $line[5] . $line[6];
        $this->coordinates = Helpers::coordinates(substr($line, 7, 17));
        $this->altitude = Helpers::feet(substr($line, 25, 5));
        $this->height = Helpers::feet(substr($line, 30, 5));

        // TODO: Implement process() method.
    }
}