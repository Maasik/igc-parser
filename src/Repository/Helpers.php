<?php

namespace Theomessin\IGCParser\Repository;

class Helpers
{
    public static function coordinates($d)
    {
        return [
            'latitude' =>  self::convertCoordinates('0' . substr($d, 0, 8)),
            'longitude' => self::convertCoordinates(substr($d, 8, 9))
        ];
    }

    private static function convertCoordinates($d)
    {
        $sign = $d[8] === 'N' || $d[8] ==='E' ? 1 : -1;
        return $sign * ((int) substr($d, 0, 3) + (int) substr($d, 3, 2) / 60 + (int) substr($d, 5, 3) / 3600);
    }

    public static function feet($metres)
    {
        return 3.28084 * $metres;
    }
}