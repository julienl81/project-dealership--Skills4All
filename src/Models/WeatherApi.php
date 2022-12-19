<?php

namespace App\Models;

class WeatherApi
{
    public static function getWeather()
    {
        // create a static method to get weather and reuse it easily in controller 
        // I use open-meteo api to get weather data
        $apiUri = 'https://api.open-meteo.com/v1/forecast?latitude=48.85&longitude=2.35&current_weather=true&timezone=auto';
        // Decode json to use it in controller
        $apiJson = json_decode(file_get_contents($apiUri));
        
        return $apiJson;
    }
}