<?php

namespace App\Services\WeatherApis;

use App\ValueObjects\DailyWeatherCollection;
use App\ValueObjects\OneDayWeather;
use Illuminate\Support\Facades\Http;

class WeatherApiApi implements WeatherSource
{
    public function getByCity(string $city): DailyWeatherCollection
    {
        $rawData = $this->getWeatherByCity($city);

        return $this->makeWeatherCollection($rawData);
    }

    private function getWeatherByCity(string $city)
    {
        return Http::get('http://api.weatherapi.com/v1/forecast.json', [
            'key' => config('services.weather.weather-api'),
            'q' => $city,
            'days' => 5
        ])->json('forecast.forecastday');
    }

    private function makeWeatherCollection($rawData): DailyWeatherCollection
    {
        $daysCollection = new DailyWeatherCollection();

        foreach ($rawData as $rawDay) {
            $day = new OneDayWeather();
            $day->setTemp($rawDay['day']['maxtemp_c']);
            $day->setDate($rawDay['date']);

            $daysCollection->addDay($day);
        }

        return $daysCollection;
    }

    public function getSourceName(): string
    {
        return 'weatherapi.com';
    }
}