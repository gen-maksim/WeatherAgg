<?php

namespace App\Services\WeatherApis;

use App\Services\CityCoordinatesApi;
use App\ValueObjects\DailyWeatherCollection;
use App\ValueObjects\OneDayWeather;
use Illuminate\Support\Facades\Http;

class OpenMeteoApi implements WeatherSource
{
    protected CityCoordinatesApi $cityCoordinatesApi;

    public function __construct(CityCoordinatesApi $cityCoordinatesApi)
    {
        $this->cityCoordinatesApi = $cityCoordinatesApi;
    }

    public function getByCity(string $city): DailyWeatherCollection
    {
        $coordinates = $this->cityCoordinatesApi->getCoordinates($city);

        $rawData = $this->getWeatherByCords($coordinates);

        return $this->makeWeatherCollection($rawData);
    }

    public function makeWeatherCollection(array $rawData): DailyWeatherCollection
    {
        $result = new DailyWeatherCollection();

        foreach ($rawData['temperature_2m_max'] as $key => $temp) {
            $day = new OneDayWeather();
            $day->setDate($rawData['time'][$key]);
            $day->setTemp($temp);

            $result->addDay($day);
        }

        return $result;
    }

    public function getWeatherByCords(array $coords): array
    {
        return Http::get('https://api.open-meteo.com/v1/forecast', [
            'longitude' => $coords['lon'],
            'latitude' => $coords['lat'],
            'daily' => 'temperature_2m_max',
            'timezone' => 'UTC'
        ])->json('daily');
    }

    public function getSourceName(): string
    {
        return 'open-meteo.com';
    }
}