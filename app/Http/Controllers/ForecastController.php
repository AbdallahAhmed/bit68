<?php

namespace App\Http\Controllers;

use Gmopx\LaravelOWM\LaravelOWM;
use Illuminate\Http\Request;

class ForecastController extends Controller
{

    public $data = array();

    /**
     * get /forecast/weather
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function weather(Request $request)
    {
        if ($request->method() == "POST") {
            try {
                $weather = new LaravelOWM();
            } catch (\Exception $e) {
                return $this->errorResponse($e, 400);
            }
            $city = $request->get('city');
            $current_weather = $weather->getCurrentWeather($city);
            if ($current_weather->city->id == 0) {
                $this->data['city'] = false;
                return redirect()->back()->withErrors(['City' => "Invalid City Name"])->withInput();
            }
            $this->data['city'] = $city;
            $this->data ['temperature'] = $current_weather->temperature->getValue()." C";
            $this->data ['humidity'] = $current_weather->humidity->getFormatted();
            $this->data ['clouds'] = $current_weather->clouds->getFormatted();
            $this->data ['pressure'] = $current_weather->pressure->getFormatted();
            $this->data ['wind_speed'] = $current_weather->wind->speed->getFormatted();
            $this->data ['wind_direction'] = $current_weather->wind->direction->getFormatted();
            return view('forecast.weather', $this->data);

        } else {
            $this->data['city'] = '';
            return view('forecast.weather', $this->data);
        }
    }
}
