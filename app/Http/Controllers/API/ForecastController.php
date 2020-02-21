<?php

namespace App\Http\Controllers\API;

use Gmopx\LaravelOWM\LaravelOWM;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForecastController extends APIController
{

    /**
     * get /forecast/weather
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function weather(Request $request)
    {
        try {
            $weather = new LaravelOWM();
        } catch (\Exception $e) {
            return $this->errorResponse($e, 400);
        }
        $city = $request->get('city');
        $current_weather = $weather->getCurrentWeather($city);

        if ($current_weather->city->id == 0) {
            return $this->errorResponse(['message' => 'Invalid City name']);
        }

        return $this->response([
            'temperature' => $current_weather->temperature->getValue()." C",
            'humidity' => $current_weather->humidity->getFormatted(),
            'clouds' => $current_weather->clouds->getFormatted(),
            'pressure' => $current_weather->pressure->getFormatted(),
            'wind' => [
                'speed' => $current_weather->wind->speed->getFormatted(),
                'direction' => $current_weather->wind->direction->getFormatted(),
            ]
        ]);
    }
}
