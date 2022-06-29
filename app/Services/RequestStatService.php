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
        if ($mode === 'all') {
            $match = [];
        } else {
            switch ($mode) {
                case 'day': $date = Carbon::now()->subDay()->toISOString();
                break;
                case 'week': $date = Carbon::now()->subWeek()->toISOString();
                break;
                case 'month': $date = Carbon::now()->subMonth()->toISOString();
                break;
            }

            $match = [[
                '$match'=> [
                    'date' => [
                        '$gte' => $date
                    ]
                ]
            ]];
        }

        return RequestStat::raw(static function ($col) use ($match, $limit) {
            $agg = [
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
            ];

            if (!empty($match)) {
                $agg = array_merge($match, $agg);
            }

            return $col->aggregate($agg);
        })->toArray();
    }
}