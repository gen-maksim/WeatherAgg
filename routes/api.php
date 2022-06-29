<?php

use App\Http\Controllers\RequestStatController;
use App\Http\Controllers\WeatherApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/weather/{city}', [WeatherApiController::class, 'getByCity']);
Route::get('/popular', [RequestStatController::class, 'getPopularEndpoint']);
