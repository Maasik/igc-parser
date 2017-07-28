<?php

namespace Theomessin\IGCParser\Repository;

class Helpers
{
    public static function coordinates($d)
    {
        $latitude = floatval(substr($d, 0, 2)) +
        floatval(substr($d, 2, 5)) / 60000.0;
        if ($d[7] === 'S') $latitude *= -1;


        $longitude = floatval(substr($d, 8, 3)) +
            floatval(substr($d, 11, 5)) / 60000.0;
        if ($d[16] === 'W') $longitude *= -1;

        return [ 'latitude' =>  $latitude, 'longitude' => $longitude ];
    }

    public static function feet($metres)
    {
        return 3.28084 * $metres;
    }
}