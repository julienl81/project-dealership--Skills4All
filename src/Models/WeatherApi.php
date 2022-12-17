<?php

namespace App\Models;

class WeatherApi
{
    public static function getWeather()
    {
        $apiUri = 'https://api.open-meteo.com/v1/forecast?latitude=48.85&longitude=2.35&current_weather=true&timezone=auto';
        $apiJson = json_decode(file_get_contents($apiUri));
        
        return $apiJson;
    }
}