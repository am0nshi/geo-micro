<?php

namespace App\Http\Controllers;

use App\Models\Whitelist;
use Carbon\Carbon;
use \Illuminate\Http\Request;
//use App\Http\Request;
use Illuminate\Support\Facades\DB;

class WhitelistController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
//        \DB::connection()->enableQueryLog();
//        app('db')->connection()->enableQueryLog();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function getAllRules(Request $request){

        $model = Whitelist::all();
        return $model->toArray();
    }

    public function createNewIpRule(Request $request){

        $this->validate($request, [
            'ip' => 'required|regex:/[\d]{1,3}\.[\d]{1,3}\.[\d]{1,3}\.[\d]{1,3}/',
//            'email' => 'required|email|unique:users'
        ]);

        $data = $request->only(['ip']);
        var_dump($data);
        Whitelist::create($data);
        print_r(\DB::getQueryLog());
        die();
//        $data['DateCreated']  = Carbon::now()->toDateString();

        Whitelist::create($data);

        return [];
    }

    public function deleteRule(Request $request){

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users'
        ]);

        return ['delete'];
    }

}
