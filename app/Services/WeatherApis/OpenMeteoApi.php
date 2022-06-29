<?php

namespace App\Services\WeatherApis;

use App\Services\CityCoordinatesApi;
use App\ValueObjects\DailyWeatherCollection;
use App\ValueObjects\OneDayWeather;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class OpenMeteoApi extends BaseWeatherApi
{
    protected CityCoordinatesApi $cityCoordinatesApi;

    public function __construct(CityCoordinatesApi $cityCoordinatesApi)
    {
        $this->cityCoordinatesApi = $cityCoordinatesApi;
    }

    /**
     * @throws RequestException
     */
    protected function tryGetWeather(string $city): DailyWeatherCollection
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

    /**
     * @throws RequestException
     */
    public function getWeatherByCords(array $coords): array
    {
        $url = config('services.weather.open_meteo.base_url')
            . config('services.weather.open_meteo.forecast_url');

        return Http::get($url, [
            'longitude' => $coords['lon'],
            'latitude' => $coords['lat'],
            'daily' => 'temperature_2m_max',
            'timezone' => 'UTC'
        ])->throw()->json('daily');
    }

    public function getSourceName(): string
    {
        return 'open-meteo.com';
    }
}