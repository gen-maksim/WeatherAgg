<?php

namespace Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;

trait ApiFaker
{
    protected function fakeAccuWeather(): void
    {
        Http::fake([
            config('services.weather.accu_weather.base_url') . '*' => function (Request $r) {
                if (str_contains($r->url(), config('services.weather.accu_weather.city_search'))) {
                    return Http::response([['Key' => 123]]);
                }

                return Http::response(
                    [
                        'DailyForecasts' =>
                            [
                                [
                                    'Date' => '2022-06-29T07:00:00+03:00',
                                    'Temperature' => [
                                        'Maximum' => ['Value' => 15],
                                    ],
                                ],
                                [
                                    'Date' => '2022-06-30T07:00:00+03:00',
                                    'Temperature' => [
                                        'Maximum' => ['Value' => 25],
                                    ],
                                ],
                            ],
                    ]
                );
            },
        ]);
    }

    protected function fakeOpenMeteo(): void
    {
        Http::fake([
            config('services.weather.open_meteo.base_url') . '*' => function (Request $r) {
                return Http::response(
                    [
                        'daily' =>
                            [
                                'time' => [
                                    '2022-06-29',
                                    '2022-06-30',
                                ],
                                'temperature_2m_max' => [
                                    15,
                                    20,
                                ],
                            ],
                    ]
                );
            },
        ]);
    }

    protected function fakeWeatherApi(): void
    {
        Http::fake([
            config('services.weather.weather_api.base_url') . '*' => function (Request $r) {
                return Http::response(
                    [
                        'forecast' =>
                            [
                                'forecastday' => [
                                    [
                                        'date' => '2022-06-29',
                                        'day' => [
                                            'maxtemp_c' => 5,
                                        ],
                                    ],
                                    [
                                        'date' => '2022-06-30',
                                        'day' => [
                                            'maxtemp_c' => 10,
                                        ],
                                    ],
                                ],
                            ],
                    ]
                );
            },
        ]);
    }
}