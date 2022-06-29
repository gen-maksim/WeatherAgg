<?php

namespace App\Services;

use App\Models\RequestStat;
use Illuminate\Support\Carbon;

class RequestStatService
{
    public function recordEndpoint(string $endpoint): void
    {
        RequestStat::create([
            'endpoint' => $endpoint,
            'date' => Carbon::now()->toDateString()
        ]);
    }

    public function getPopular(string $mode, int $limit): array
    {
        return RequestStat::raw(static function ($col) use ($mode, $limit) {
            return $col->aggregate([
                [
                    '$group' => [
                        '_id' => '$endpoint',
                        'count' => [
                            '$sum' => 1,
                        ]
                    ]
                ],
                [
                    '$sort' => [
                        'count' => -1
                    ]
                ],
                [
                    '$limit' => $limit
                ]
            ]);
        })->toArray();
    }
}