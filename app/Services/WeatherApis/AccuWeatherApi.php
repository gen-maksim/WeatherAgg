<?php

namespace App\Services\WeatherApis;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class AccuWeatherApi implements WeatherSource
{
    public function getByCity(string $city): array
    {
        $key = $this->getLocationKey($city);

        $weather = [];
        foreach ($this->getWeather($key) as $day) {
            $date = Carbon::parse($day['Date'])->toDateString();
            $temp = $day['Temperature']['Maximum']['Value'];
            $weather[$date] = $temp;
        }

        return $weather;
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
}