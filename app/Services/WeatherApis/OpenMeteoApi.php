<?php

namespace App\Services\WeatherApis;

use App\Services\CityCoordinatesApi;
use Illuminate\Support\Facades\Http;

class OpenMeteoApi implements WeatherSource
{
    protected CityCoordinatesApi $cityCoordinatesApi;

    public function __construct(CityCoordinatesApi $cityCoordinatesApi)
    {
        $this->cityCoordinatesApi = $cityCoordinatesApi;
    }

    public function getByCity(string $city): array
    {
        $coordinates = $this->cityCoordinatesApi->getCoordinates($city);

        return $this->getWeatherCords($coordinates);
    }

    public function getWeatherCords(array $coords): array
    {
        $response = Http::get('https://api.open-meteo.com/v1/forecast', [
            'longitude' => $coords['lon'],
            'latitude' => $coords['lat'],
            'daily' => 'temperature_2m_max',
            'timezone' => 'UTC'
        ]);

        $result = [];
        foreach ($response->json('daily.temperature_2m_max') as $key => $temp) {
            $result[$response->json("daily.time.$key")] = $temp;
        }

        return $result;
    }
}