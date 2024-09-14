<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\CategoryController;
use App\Models\Brand;
use App\Models\CityList;
use App\Models\GenderList;
use App\Models\PressAndMedia;
use App\Models\Product;
use App\Models\Slider;
use App\Models\ThanaList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
        $newsItem = PressAndMedia::where('status',1)->get(['logo']);
        $categoryObject = new CategoryController();
        $categories =     $categoryObject->getSubCategory(1)->getData();
        $brands =['Select Brand']+ Brand::where('status',1)->pluck('name','id')->toArray();
        $products = Product::where('is_published',1)->where('category_id',1)->limit(30)->get();
        $sliders = Slider::all();
        return view('userPanel.dashboard',compact('categories','newsItem','brands','products','sliders'));
    }

}
