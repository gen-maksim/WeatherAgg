<?php

namespace App\Providers;

use App\Services\WeatherApis\AccuWeatherApi;
use App\Services\WeatherApis\OpenMeteoApi;
use App\Services\WeatherApis\WeatherApiApi;
use App\Services\WeatherSources;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(
        OpenMeteoApi $openMeteoApi,
        AccuWeatherApi $accuWeatherApi,
        WeatherApiApi $weatherApiApi
    ): void
    {
        WeatherSources::addSource($openMeteoApi);
        WeatherSources::addSource($accuWeatherApi);
        WeatherSources::addSource($weatherApiApi);
    }
}
