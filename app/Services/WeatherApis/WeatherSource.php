<?php

namespace App\Services\WeatherApis;

use App\ValueObjects\DailyWeatherCollection;

interface WeatherSource
{
    public function getByCity(string $city): DailyWeatherCollection;

    public function getSourceName(): string;
}