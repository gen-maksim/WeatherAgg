<?php

namespace App\Services\WeatherApis;

use App\ValueObjects\DailyWeatherCollection;
use Illuminate\Support\Facades\Log;

abstract class BaseWeatherApi implements WeatherSource
{
    final public function getByCity(string $city): DailyWeatherCollection
    {
        try {
            $forecast = $this->tryGetWeather($city);
        } catch (\Throwable $e) {
            Log::info('Error with ' . $this->getSourceName());
            Log::error(get_class($e));
            Log::error($e->getMessage());
            Log::error($e->getTraceAsString());

            return new DailyWeatherCollection();
        }

        return $forecast;
    }

    abstract protected function tryGetWeather(string $city): DailyWeatherCollection;
}