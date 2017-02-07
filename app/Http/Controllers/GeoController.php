<?php

namespace App\Http\Controllers;

//use \Illuminate\Http\Request;
//use App\Http\Request;
//use Illuminate\Support\Facades\DB;

use GeoIp2\Database\Reader;

class GeoController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
//        \DB::connection()->enableQueryLog();
//        app('db')->connection()->enableQueryLog();
    }

    /**
     * @param string $ip
     * @return array
     */
    public function getData($ip)//, Request $request
    {
        $validator = app('validator')->make(['ip'=>$ip], [
            'ip' => 'required|ip'
        ]);
        if($validator->fails()){
            abort(500,'Bad ip format');
        }

        try {
            $reader = new Reader(storage_path('app').'/city.mmdb');
            $data   = $reader->city($ip);
            $reader->close();

            $countries  = require_once storage_path('app').'/countries.php';
            $currencies = require_once storage_path('app').'/currencies.php';

            $country  = $countries[strtoupper($data->country->isoCode)];
            $currency = $currencies[strtoupper($data->country->isoCode)];

            $timezones     = [];
            $timezoneNames = \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, strtoupper($data->country->isoCode));

            foreach ($timezoneNames as $timezoneName) {
                $date        = new \DateTime("now", new \DateTimeZone($timezoneName));
                $timezones[] = $date->format('O');
            }

            return response()->json(
                [
                    'name'     => $data->country->name,
                    'iso'      => $data->country->isoCode,
                    'currency' => $currency,
                    'prefix'   => $country['phonePrefix'],
                    'zone'     => $timezones,
                    'region'   => $data->mostSpecificSubdivision->name,
                    'city'     => $data->city->names,
                ]
            );
        } catch (\Exception $exception) {
            return response()->json(
                'No country found for this IP'
            );
        }
    }


}
