<?php

namespace App\Services;

use App\ValueObjects\OneDayWeather;

class WeatherService
{
    public function getByCity(string $city): array
    {
        $result = [];
        while (($source = WeatherSources::getSource()) !== null) {
            $daysCollection = $source->getByCity($city);
            $weather = [];
            foreach ($daysCollection->getDays() as $day) {
                /** @var OneDayWeather $day */
                $date = $day->getDate();
                $temp = $day->getTemp();

                $weather[$date] = $temp;
            }
            $result[] = [
                'name' => $source->getSourceName(),
                'weather' => $weather,
            ];
        }

        $result['avg'] = $this->getAverageWeather($result);

        return $result;
    }

    public function getAverageWeather(array $allSources): array
    {
        $avgWeather = [];

        foreach ($allSources as $source) {
            foreach ($source['weather'] as $date => $temp) {
                if  (!array_key_exists($date, $avgWeather)) {
                    $avgWeather[$date] = [];
                }

                $avgWeather[$date][] = $temp;
            }
        }

        return array_map(static fn ($temps) => round(array_sum($temps) / count($temps), 1), $avgWeather);
    }
}