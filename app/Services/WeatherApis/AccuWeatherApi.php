<?php

namespace App\Services\WeatherApis;

use App\ValueObjects\DailyWeatherCollection;
use App\ValueObjects\OneDayWeather;
use Illuminate\Support\Facades\Http;

class AccuWeatherApi implements WeatherSource
{
    public function getByCity(string $city): DailyWeatherCollection
    {
        $key = $this->getLocationKey($city);

        return $this->makeWeatherCollection($this->getWeather($key));
    }

    public function makeWeatherCollection(array $rawData): DailyWeatherCollection
    {
        $result = new DailyWeatherCollection();

        foreach ($rawData as $rawDay) {
            $day = new OneDayWeather();
            $day->setDate($rawDay['Date']);
            $day->setTemp($rawDay['Temperature']['Maximum']['Value']);

            $result->addDay($day);
        }

        return $result;
    }

    public function getWeather($key): array
    {
        return Http::get("http://dataservice.accuweather.com/forecasts/v1/daily/5day/$key", [
            'apikey' => config('services.weather.accu-weather'),
            'metric' => 'true',
        ])->json('DailyForecasts');
    }

    public function getLocationKey(string $city): string
    {
        return Http::get('http://dataservice.accuweather.com/locations/v1/cities/search', [
            'apikey' => config('services.weather.accu-weather'),
            'q' => $city,
        ])->json('0.Key');
    }

    public function getSourceName(): string
    {
        return 'accuweather.com';
    }
}