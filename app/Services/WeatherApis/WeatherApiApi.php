<?php

namespace App\Services\WeatherApis;

use App\ValueObjects\DailyWeatherCollection;
use App\ValueObjects\OneDayWeather;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class WeatherApiApi extends BaseWeatherApi
{
    /**
     * @throws RequestException
     */
    protected function tryGetWeather(string $city): DailyWeatherCollection
    {
        $rawData = $this->getWeatherByCity($city);

        return $this->makeWeatherCollection($rawData);
    }

    /**
     * @throws RequestException
     */
    private function getWeatherByCity(string $city)
    {
        $url = config('services.weather.weather_api.base_url')
            . config('services.weather.weather_api.forecast_url');

        return Http::get($url, [
            'key' => config('services.weather.weather_api.key'),
            'q' => $city,
            'days' => 5
        ])->throw()->json('forecast.forecastday');
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