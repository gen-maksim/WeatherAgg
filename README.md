## About Weather aggregator

Added weather Apis
- [WeatherApi](https://www.weatherapi.com/).
- [Accuweather](https://developer.accuweather.com/home).
- [Open-meteo](https://open-meteo.com/en) (it also depends on [Positionstack](https://positionstack.com/))

In order to use those sources, make sure you have all needed api keys

## Api docs

https://documenter.getpostman.com/view/13093105/UzBvH3zq

## Installation
1. Clone repo.
1. Copy .env.example to .env
1. Fill weather tokens if you have them (in .env)
1. Run `docker-compose up`

By default server will run on localhost:8000

## How to add another source

To add a new source of weather, you have to create another class that extends BaseWeatherApi.php and register your new class in AppServiceProvider.php.

That's it. Now your source will be shown in the list. If forecast is empty, go to logs, issue written there.

