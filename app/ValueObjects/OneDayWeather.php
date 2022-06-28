<?php

namespace App\ValueObjects;

use Illuminate\Support\Carbon;

class OneDayWeather
{
    private string $date;
    private float $temp;

    public function setDate(string $date): void
    {
        $this->date = Carbon::parse($date)->toDateString();
    }

    public function setTemp(string $temp): void
    {
        $this->temp = round((float) $temp, 1);
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getTemp(): float
    {
        return $this->temp;
    }
}