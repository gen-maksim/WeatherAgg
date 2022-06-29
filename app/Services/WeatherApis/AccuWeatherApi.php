<?php

namespace App\Services\WeatherApis;

use App\ValueObjects\DailyWeatherCollection;
use App\ValueObjects\OneDayWeather;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

class AccuWeatherApi extends BaseWeatherApi
{
    /**
     * @throws RequestException
     */
    protected function tryGetWeather(string $city): DailyWeatherCollection
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

    /**
     * @throws RequestException
     */
    public function getWeather($key): array
    {
        $url = config('services.weather.accu_weather.base_url')
            . config('services.weather.accu_weather.forecast_url') . $key;

        return Http::get($url, [
            'apikey' => config('services.weather.accu_weather.key'),
            'metric' => 'true',
        ])->throw()->json('DailyForecasts');
    }

    /**
     * @throws RequestException
     */
    public function getLocationKey(string $city): string
    {
        $url = config('services.weather.accu_weather.base_url')
            . config('services.weather.accu_weather.city_search');

        return Http::get($url, [
            'apikey' => config('services.weather.accu_weather.key'),
            'q' => $city,
        ])->throw()->json('0.Key');
    }

    public function getSourceName(): string
    {
        return 'accuweather.com';
    }
}