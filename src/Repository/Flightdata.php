<?php

namespace Theomessin\IGCParser\Repository;

use Carbon\Carbon;
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
     * Collection of H Records (headers)
     *
     * @var  \Illuminate\Support\Collection
     */
    protected $headers;

    /**
     * Collection of B Records (fixes)
     *
     * @var  \Illuminate\Support\Collection
     */
    protected $fixes;

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
        $this->fixes = collect();
        $this->records = collect();
        $this->headers = collect();

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
        if ($line === "" || $line === null) return null;
        $recordMap = [
            'A' => "AlphaRecord", 'B' => "BravoRecord", 'C' => "CharlieRecord", 'D' => "DeltaRecord",
            'E' => "EchoRecord", 'F' => "FoxtrotRecord", 'G' => "GolfRecord", 'H' => "HotelRecord",
            'I' => "IndiaRecord", 'J' => "JulietRecord", 'K' => "KiloRecord", 'L' => "LimaRecord",
        ];
        $recordClass = "\\Theomessin\\IGCParser\\Repository\\Records\\" . $recordMap[$line[0]];
        return new $recordClass($line);
    }

    /**
     * Process a given record to extract data.
     *
     * @param \Theomessin\IGCParser\Repository\Records\Record $record|null
     * @return void
     */
    protected function process(?Record $record)
    {
        if ($record === null) return;
        $this->records->push($record);

        if(class_basename(get_class($record)) === "HotelRecord")
            $this->headers->push($record);
        else if(class_basename(get_class($record)) === "BravoRecord")
            $this->fixes->push($record);
    }

    /**
     *
     */
    protected function postProcess()
    {
        $date = $this->headers->filter(function($value, $key) {
            return $value->subtype === "DTE";
        })->first()->data;
        $pic = $this->headers->filter(function($value, $key) {
            return $value->subtype === "PLT";
        })->first()->data;
        $type = $this->headers->filter(function($value, $key) {
            return $value->subtype === "GTY";
        })->first()->data;
        $id = $this->headers->filter(function($value, $key) {
            return $value->subtype === "GID";
        })->first()->data;

        $this->date = Carbon::createFromFormat('dmy', explode(',', $date)[0])->toDateString();
        $this->pilotInCommand = ucfirst(strtolower($pic));
        $this->gliderType = $type;
        $this->gliderId = $id;
    }
}