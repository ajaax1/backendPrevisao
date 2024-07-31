<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ApiTempo extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function api($cidade)
    {
        $responseGeo = Http::get("http://api.openweathermap.org/geo/1.0/direct?q=$cidade&appid=0a06f95727a0a65a8165050db073611c");

        if ($responseGeo->successful()) {
            $geoData = $responseGeo->json();
            $lat = $geoData[0]['lat'];
            $lon = $geoData[0]['lon'];

            $responseWeather = Http::get("https://api.openweathermap.org/data/2.5/forecast?lat=$lat&lon=$lon&appid=0a06f95727a0a65a8165050db073611c&units=metric&lang=pt_br");

            if ($responseWeather->successful()) {
                $weatherData = $responseWeather->json();
                return response()->json($weatherData);
            } else {
                return response()->json(['error' => 'Erro ao obter a previsão do tempo'], 500);
            }
        } else {
            return response()->json(['error' => 'Erro ao obter a localização'], 500);
        }
    }

}


