<?php

namespace Theomessin\IGCParser\Repository\Records;

use Theomessin\IGCParser\Repository\Records\Record;
use Theomessin\IGCParser\Contracts\SpecificRecord as RecordContract;

class HotelRecord extends Record implements RecordContract
{
    public $source;
    public $subtype;
    public $data;

    protected function process($line)
    {
        $this->source = $line[1];
        $this->subtype = $line[2] . $line[3] . $line[4];

        $this->data = explode(':', $line);
        if (count($this->data) === 1) $this->data = substr($this->data[0], 5);
        else $this->data = $this->data[1];

        // TODO: Implement process() method.
    }
}