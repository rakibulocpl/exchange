<?php

namespace App\Http\Controllers\user;

use App\Models\CityList;
use App\Models\GenderList;
use App\Models\ThanaList;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function myAccount(){
        $userData = User::where('id',Auth::user()->id)->first();
        $city  = CityList::where('status',1)->pluck('city_name as display','id')->toArray();
        $gender  = GenderList::where('status',1)->pluck('gender_name as display','id')->toArray();
        return view('userPanel.profile',compact('city','gender','userData'));
    }
}
