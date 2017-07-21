<?php

namespace Theomessin\IGCParser\Repository;

use Theomessin\IGCParser\Repository\Records\Record;
use Illuminate\Contracts\Filesystem\Filesystem as File;
use Theomessin\IGCParser\Contracts\FileNotFoundException;
use Theomessin\IGCParser\Repository\Traits\HasFlightInformation;
use Theomessin\IGCParser\Contracts\Flightdata as FlightdataContract;

class Flightdata implements FlightdataContract
{

    use HasFlightInformation;

    /**
     * @var \Illuminate\Contracts\Filesystem\Filesystem $file
     */
    protected $file;

    /**
     * Collection of Records
     *
     * @var  \Illuminate\Support\Collection
     */
    protected $records;

    /**
     * Instantiate a new Flightdata object.
     *
     * @param \Illuminate\Contracts\Filesystem\Filesystem $file
     * @param string $path
     *
     * @throws \Theomessin\IGCParser\Contracts\FileNotFoundException
     */
    public function __construct(File $file, $path)
    {
        $this->file = $file;

        if (!$this->file->exists($path)) throw new FileNotFoundException;
        foreach(explode("\r\n", $this->file->get($path)) as $line)
            $this->process($this->make($line));

        $this->postProcess();
    }

    /**
     * Make a new Record object from an IGC line.
     *
     * @param $line
     * @return \Theomessin\IGCParser\Repository\Records\Record|null
     */
    protected function make($line)
    {
        $recordClass = "\\Theomessin\\IGCParser\\Repository\\Records\\";
        switch($line[0])
        {
            case 'A':
                $recordClass .= "AlphaRecord";
                break;
            case 'B':
                $recordClass .= "BravoRecord";
                break;
            case 'C':
                $recordClass .= "CharlieRecord";
                break;
            case 'D':
                $recordClass .= "DeltaRecord";
                break;
            case 'E':
                $recordClass .= "EchoRecord";
                break;
            case 'F':
                $recordClass .= "FoxtrotRecord";
                break;
            case 'G':
                $recordClass .= "GolfRecord";
                break;
            case 'H':
                $recordClass .= "HotelRecord";
                break;
            case 'I':
                $recordClass .= "IndiaRecord";
                break;
            case 'J':
                $recordClass .= "JulietRecord";
                break;
            case 'K':
                $recordClass .= "KiloRecord";
                break;
            case 'L':
                $recordClass .= "LimaRecord";
                break;
            default:
                return null;
        }

        return new $recordClass($line);
    }

    /**
     * Process a given record to extract data.
     *
     * @param \Theomessin\IGCParser\Repository\Records\Record $record|null
     * @return void
     */
    protected function process(Record $record)
    {
        if ($record === null) return;
        $this->records->push($record);
    }

    /**
     *
     */
    protected function postProcess()
    {
       //
    }
}