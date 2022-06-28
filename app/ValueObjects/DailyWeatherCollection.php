<?php

namespace App\ValueObjects;

use TypeError;

class DailyWeatherCollection
{
    protected array $days = [];

    public function addDay(OneDayWeather $dayWeather): void
    {
        $this->days[] = $dayWeather;
    }

    public function addManyDays(array $days): void
    {
        foreach ($days as $day) {
            if (! $day instanceof OneDayWeather) {
                throw new TypeError();
            }

            $this->addDay($day);
        }
    }

    public function getDays(): array
    {
        return $this->days;
    }
}