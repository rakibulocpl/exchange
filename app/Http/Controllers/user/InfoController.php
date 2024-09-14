<?php

namespace App\Http\Controllers\user;

use App\Models\CityList;
use App\Models\GenderList;
use App\Models\ThanaList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InfoController extends Controller
{
    public function getCityList(){
        $city  = CityList::where('status',1)->get(['id','city_name as display'])->toArray();
        return response()->json($city);
    }

    public function getGender(){
        $gender  = GenderList::where('status',1)->get(['id','gender_name as display'])->toArray();
        return response()->json($gender);
    }

    public function thanaListByCity($cityId){
        $gender  = ThanaList::where('status',1)
            ->where('city_id',$cityId)
            ->get(['id','thana_name as display'])->toArray();
        return response()->json($gender);
    }
}
