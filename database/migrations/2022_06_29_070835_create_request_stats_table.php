<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRequestStatsTable extends Migration
{
    public function up(): void
    {
        Schema::create('request_stats', function (\Jenssegers\Mongodb\Schema\Blueprint $collection) {
            $collection->index('date');
            $collection->index('endpoint');
        });
    }

    public function down(): void
    {
        Schema::drop('request_stats');
    }
}
