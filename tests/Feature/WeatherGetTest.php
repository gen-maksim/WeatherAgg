<?php

namespace Tests\Feature;

use App\Services\WeatherApis\AccuWeatherApi;
use App\Services\WeatherApis\OpenMeteoApi;
use Tests\TestCase;

class WeatherGetTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testEndpointWorks()
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/api/weather/moscow');

        $response->assertStatus(200);
    }

    public function testEndpointReturnsGrades()
    {
        $this->withoutExceptionHandling();
        $weather = app(OpenMeteoApi::class)->getByCity('moscow');

        $this->assertGreaterThan(1, count($weather));
    }

    public function testAccuWeatherApiReturnsGrades()
    {
        $this->withoutExceptionHandling();
        $weather = app(AccuWeatherApi::class)->getByCity('moscow');

        $this->assertGreaterThan(1, count($weather));
    }
}
