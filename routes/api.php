<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*info*/

Route::get('info/get-city','App\Http\Controllers\InfoController@getCityList')->name('info.cityList');
Route::get('info/get-gender','App\Http\Controllers\InfoController@getGender')->name('info.genderList');
Route::get('info/get-thana/{cityId}','App\Http\Controllers\InfoController@thanaListByCity')->name('info.thanaListByCity');

/*category*/
Route::get('info/sub-category/{parentId}','App\Http\Controllers\CategoryController@getSubCategory')->name('info.subcategory')->middleware('auth:api');;
Route::get('info/category/{categoryId}','App\Http\Controllers\CategoryController@getCategoryById')->name('info.categoryById')->middleware('auth:api');;

/*deal*/
Route::post('newdeal/{categoryId}','App\Http\Controllers\DealController@newDeal')->name('deal.newstore')->middleware('auth:api');;
Route::get('deal/list','App\Http\Controllers\DealController@dealList')->middleware('auth:api');;
Route::get('deal/get-deal-by-track-no/{trackNo}','App\Http\Controllers\DealController@getDealDetails')->middleware('auth:api');;



Route::get('info/brand-list','App\Http\Controllers\BrandController@getBrandList')->name('info.brandList')->middleware('auth:api');;
Route::post('sendotp','App\Http\Controllers\AuthController@sendotp')->name('auth.sendotp');
Route::post('verify-otp','App\Http\Controllers\AuthController@veirfyOtp')->name('auth.verifyotp');
Route::post('register','App\Http\Controllers\AuthController@register')->name('auth.register');
Route::get('user','App\Http\Controllers\AuthController@user')->name('auth.user')->middleware('auth:api');

