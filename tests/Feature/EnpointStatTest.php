<?php

namespace Tests\Feature;

use App\Models\RequestStat;
use App\Services\RequestStatService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class EnpointStatTest extends TestCase
{
    use DatabaseMigrations;
    use WithFaker;

    public function testEndpointReturnsPopular(): void
    {
        RequestStat::factory(2)->create();
        $response = $this->get('/api/popular?limit=1');

        $response->assertStatus(200)
            ->assertJsonStructure([
                ['endpoint', 'call_count']
            ]);
    }

    public function testStatsRecorded(): void
    {
        /** @var RequestStatService $service */
        $service = app(RequestStatService::class);
        $endpoint = implode('-', $this->faker->words());
        $service->recordEndpoint($endpoint);

        $this->assertTrue(RequestStat::where('endpoint', $endpoint)->exists());
    }

    public function testStatsReturned(): void
    {
        /** @var RequestStatService $service */
        $service = app(RequestStatService::class);
        RequestStat::factory(2)->create(['endpoint' => implode('-', $this->faker->words())]);
        RequestStat::factory(3)->create(['endpoint' => implode('-', $this->faker->words())]);

        $lastEndpoint = implode('-', $this->faker->words());
        RequestStat::factory(1)->create(['endpoint' => $lastEndpoint]);

        $result = $service->getPopular('day', 10);
        $this->assertCount(3, $result);
        $this->assertCount(2, $result[0]);
        $this->assertEquals($lastEndpoint, array_pop($result)['_id']);
    }

    public function testDateFilter(): void
    {
        /** @var RequestStatService $service */
        $service = app(RequestStatService::class);

        RequestStat::factory(2)->create([
            'endpoint' => implode('-', $this->faker->words()),
            'date' => Carbon::now()->toDateString(),
        ]);
        RequestStat::factory(3)->create([
            'endpoint' => implode('-', $this->faker->words()),
            'date' => Carbon::now()->subWeeks(3)->toDateString(),
        ]);

        $result = $service->getPopular('week', 10);
        $this->assertCount(1, $result);

        $result = $service->getPopular('all', 10);
        $this->assertCount(2, $result);
    }
}
