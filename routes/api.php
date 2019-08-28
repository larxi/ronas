<?php

use Illuminate\Http\Request;
use GuzzleHttp\Client;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/weather', function(Request $request) {

    $client = new Client();
    $lat = $request->get('lat');
    $lon = $request->get('lon');
    // return response()->json($lat);
    $response = $client->request('GET',
    'https://api.weather.yandex.ru/v1/forecast?lat='.$lat.'&lon='.$lon.'&lang=ru_RU&hours=0&limit=1&extra=false', [
        'headers' => ['X-Yandex-API-Key' => '1c442bcb-5b37-4ec3-b68c-cec1f2b356af']
    ]);
    $body = $response->getBody();
    return $body;
});