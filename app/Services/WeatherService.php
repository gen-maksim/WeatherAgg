<?php

namespace App\Services;

use App\Services\WeatherApis\AccuWeatherApi;
use App\Services\WeatherApis\OpenMeteoApi;

class WeatherService
{
    protected array $sources = [
        OpenMeteoApi::class,
        AccuWeatherApi::class,
    ];

    public function getByCity(string $city): array
    {
        $result = [];
        foreach ($this->sources as $source) {
            $one = app($source)->getByCity($city);
            foreach ($one as $day => $temp) {
                if  (!array_key_exists($day, $result)) {
                    $result[$day] = [];
                }

                $result[$day][] = $temp;
            }
        }

        return array_map(static fn ($temps) => round(array_sum($temps) / count($temps), 1), $result);
    }
}