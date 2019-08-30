<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;


class WeatherController extends Controller
{
    public function index(Request $request)
    {
        $client = new Client();
        $lat = $request->get('lat');
        $lon = $request->get('lon');
        $response = $client->request('GET',
        'https://api.weather.yandex.ru/v1/forecast?lat='.$lat.'&lon='.$lon.'&lang=ru_RU&hours=0&limit=1&extra=false', [
            'headers' => ['X-Yandex-API-Key' => '1c442bcb-5b37-4ec3-b68c-cec1f2b356af']
        ]);
        $body = $response->getBody();
        return $body;
    }
}
