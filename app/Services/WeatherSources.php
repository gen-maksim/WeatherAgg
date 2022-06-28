<?php

namespace App\Services;

use App\Services\WeatherApis\WeatherSource;

class WeatherSources
{
    private static array $sources = [];

    public static function addSource(WeatherSource $source): void
    {
        self::$sources[] = $source;
    }

    public static function getSource(): ?WeatherSource
    {
        return array_pop(self::$sources);
    }
}