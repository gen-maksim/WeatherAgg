<?php

namespace App\Services\WeatherApis;

interface WeatherSource
{
    public function getByCity(string $city): array;
}