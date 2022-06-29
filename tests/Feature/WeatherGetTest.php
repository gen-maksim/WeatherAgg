<?php

namespace Tests\Feature;

use App\Services\WeatherApis\AccuWeatherApi;
use App\Services\WeatherApis\OpenMeteoApi;
use App\Services\WeatherApis\WeatherApiApi;
use Tests\ApiFaker;
use Tests\TestCase;

class WeatherGetTest extends TestCase
{
    use ApiFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fakeWeatherApi();

        $this->fakeOpenMeteo();

        $this->fakeAccuWeather();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testWeatherEndpointStatus(): void
    {
        $response = $this->get('/api/weather/paris');

        $response->assertStatus(200);
    }

    public function testEndpointReturnsGrades(): void
    {
        $this->withoutExceptionHandling();
        $weather = app(OpenMeteoApi::class)->getByCity('moscow');

        $this->assertGreaterThan(1, count($weather->getDays()));
    }

    public function testAccuWeatherApiReturnsGrades(): void
    {
        $this->withoutExceptionHandling();
        $weather = app(AccuWeatherApi::class)->getByCity('moscow');

        $this->assertGreaterThan(1, count($weather->getDays()));
    }

    public function testWeatherApiApi(): void
    {
        $this->withoutExceptionHandling();
        $weather = app(WeatherApiApi::class)->getByCity('moscow');

        $this->assertGreaterThan(1, count($weather->getDays()));
    }
}
