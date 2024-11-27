<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', 'App\Http\Controllers\user\AuthController@login')->name('userLogin');
Route::get('/about-us', 'App\Http\Controllers\PagesController@aboutUs')->name('aboutUs');
Route::get('/privacy', 'App\Http\Controllers\PagesController@privacy')->name('privacy');
Route::get('page/{pageKey}', 'App\Http\Controllers\PagesController@pagePublicView')->name('pagePublicView');

Route::get('/terms-conditions', 'App\Http\Controllers\PagesController@termsConditions')->name('termsCondition');
Route::get('/team', 'App\Http\Controllers\PagesController@team')->name('team');
Route::get('/career', 'App\Http\Controllers\PagesController@career')->name('career');
Route::get('/clients', 'App\Http\Controllers\PagesController@clients')->name('clients');
Route::get('/exchange-policy', 'App\Http\Controllers\PagesController@exchangePolicy')->name('exchangePolicy');
Route::post('/upload-image', 'App\Http\Controllers\ImageUploadController@uploadImage')->name('upload.image');
Route::get('/press-and-media', 'App\Http\Controllers\PagesController@pressAndMedia')->name('pressAndMedia');
Route::group(['as'=>'user.','namespace' => 'App\Http\Controllers\user'], function(){
    Route::get('/', 'DashboardController@index');
    Route::get('/exchange/{catId?}','DealController@NewDealForm')->name('exchangeForm');
    Route::get('/sell/{catId?}','DealController@NewDealForm')->name('sellForm');
    Route::get('/upgrade/{catId?}','DealController@upgradeForm')->name('upgradeForm');
    Route::post('upgrade','DealController@storeUpgrade')->name('storeUpgrade');
    Route::post('sendotp','AuthController@sendotp')->name('sendotp');
    Route::get('verify-otp','AuthController@verifyOtpView');
    Route::post('verify-otp','AuthController@veirfyOtp')->name('verifyOtp');
    Route::post('register','AuthController@register')->name('register');
    Route::get('register','AuthController@registerView');
    Route::get('info/get-thana/{cityId}','InfoController@thanaListByCity')->name('thanaListByCity');
    Route::get('update/confirmation','DealController@confirmationUpdate')->name('updateConfirmation');

    /*shop*/
    Route::get('/shop','ShopController@index')->name('shop');
    Route::get('/category/{slug}','ShopController@shopByCategory')->name('shopByCategory');
    Route::get('/shop/{product}','ShopController@viewProduct')->name('viewProduct');
    Route::get('/checkout/cart','CartController@index')->name('viewCart');
    Route::post('/checkout/store','CartController@checkout')->name('checkout');
    Route::post('/cart/add','CartController@addToCart')->name('addToCart');
    Route::get('/cart/remove-item/{id}','CartController@removeItem')->name('removeItem');
    Route::post('/select-for-exchange','CartController@selectForExchange')->name('selectForExchange');
});

Route::group(['middleware' => ['authUser'],'as'=>'user.','namespace' => 'App\Http\Controllers\user'], function(){
    Route::get('my-account','UserController@myAccount');
    Route::get('my-deal','DealController@myDeal');
    /*deal*/
    Route::post('newdeal','DealController@newDeal')->name('newstore');
    Route::get('deal/list','App\Http\Controllers\DealController@dealList')->name('dealList');
    Route::get('deal/get-deal-by-track-no/{trackNo}','App\Http\Controllers\DealController@getDealDetails');
    Route::get('deal/view/{trackNo}','DealController@viewDeal')->name('dealView');
    Route::get('deal/confirmation','DealController@confirmation')->name('dealConfirmation');

});

Route::group(['prefix' => 'admin'], function(){
    Route::get('/', function () {
        return view('auth.login');
    });
    Auth::routes();
});



Route::group(['middleware' => ['auth','checkAdmin'],'prefix' => 'admin',  'namespace' => 'App\Http\Controllers\site'], function() {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard.index');

    /*user*/

    Route::get('user/list','UserController@index')->name('user.list');
    Route::get('user/get-user-list','UserController@getlist')->name('user.getlist');
    Route::get('user/add','UserController@add')->name('user.add');
    Route::post('user/store','UserController@store')->name('user.store');
    Route::get('user/edit/{user_id}','UserController@edit')->name('user.edit');
    Route::post('user/update','UserController@updateUser')->name('user.update');
    Route::get('user/permission/{user_id}','UserController@userPermission')->name('user.permission');
    Route::post('user/permission-store','UserController@userPermissionStore')->name('user.permissionStore');
    Route::get('user/profile','UserController@profile')->name('user.profile');
    Route::post('user/profile/update-details','UserController@detailsUpdate')->name('user.profile-details-update');
    Route::post('user/profile/update-image','UserController@imageUpdate')->name('user.profile-image-update');
    Route::post('user/profile/change-password','UserController@passwordUpdate')->name('user.profile-change-password');


    /*settings start*/

    Route::get('settings/branch/list','BranchController@index')->name('branch.list');
    Route::get('settings/branch/get-user-list','BranchController@getlist')->name('branch.getlist');
    Route::get('settings/branch/add','BranchController@add')->name('branch.add');
    Route::post('settings/branch/store','BranchController@store')->name('branch.store');
    Route::get('settings/branch/edit/{branch_id}','BranchController@edit')->name('branch.edit');
    Route::post('settings/branch/update','BranchController@updateUser')->name('branch.update');
    Route::get('settings/branch/view/{branch_id}','BranchController@add')->name('branch.view');
    Route::get('settings/press-media/list','PressMediaController@index')->name('pressMedia.list');
    Route::get('settings/press-media/add','PressMediaController@add')->name('pressMedia.add');
    Route::get('settings/press-media/edit/{id}','PressMediaController@edit')->name('pressMedia.edit');
    Route::post('settings/press-media/store','PressMediaController@store')->name('pressMedia.store');
    Route::post('settings/press-media/update','PressMediaController@update')->name('pressMedia.update');

    /*pages*/
    Route::get('settings/page/list','PageController@index')->name('page.list');
    Route::get('settings/page/add','PageController@add')->name('page.add');
    Route::post('settings/page/store}','PageController@store')->name('page.store');
    Route::get('settings/page/edit/{id}','PageController@edit')->name('page.edit');
    Route::get('settings/page/delete/{id}','PageController@delete')->name('page.delete');

    Route::get('settings/slider/list','SliderController@index')->name('slider.list');
    Route::get('settings/slider/add','SliderController@add')->name('slider.add');
    Route::post('settings/slider/store}','SliderController@store')->name('slider.store');
    Route::get('settings/slider/edit/{id}','SliderController@edit')->name('slider.edit');
    Route::get('settings/slider/delete/{id}','SliderController@delete')->name('slider.delete');





    /*deal*/
    Route::get('deal/exchange','DealController@index')->name('deal.list');
    Route::post('user/update-note','DealController@updateNote')->name('deal.updateNote');
    Route::get('deal/sell','DealController@index')->name('deal.sellList');
    Route::get('deal/upgrade-list','DealController@upgradeList')->name('deal.upgradeList');

    Route::get('deal/getlist/{dealType}','DealController@getlist')->name('deal.getlist');
    Route::get('deal/getlist-upgrade}','DealController@getlistUpgrade')->name('deal.getlistUpgrade');
    Route::get('deal/view-upgrade/{dealId}','DealController@upgradeView')->name('deal.upgradeView');
    Route::get('deal/view/{dealId}','DealController@viewDeal')->name('deal.view');
    Route::post('deal/sent-estimated-price','ManageDealController@sentEstimatedPrice')->name('deal.sentEstimatedPrice');
    Route::post('deal/sent-upgrade-cost','ManageDealController@sendUpgradeCost')->name('deal.sendUpgradeCost');
    Route::post('deal/send-general-sms','ManageDealController@sendSms')->name('deal.sendSms');

    Route::get('deal/order','OrderController@index')->name('order.orderList');
    Route::get('deal/order/view/{orderId}','OrderController@view')->name('order.view');
    Route::get('deal/order/get-list','OrderController@getList')->name('order.getList');

    /*deal download*/
    Route::get('deal/download-deal','ManageDealController@downloadDeal')->name('deal.downloadDeal');
    Route::post('deal/download','ManageDealController@download')->name('deal.download');
    /*products*/
    Route::get('product','ProductController@index')->name('product.list');
    Route::get('product/add','ProductController@create')->name('product.add');
    Route::post('product/store','ProductController@store')->name('product.store');
    Route::get('product/exit/{id}','ProductController@edit')->name('product.edit');
    Route::get('product/view/{productId}','ProductController@view')->name('product.view');
    Route::get('product/get-list','ProductController@getList')->name('product.getList');
    Route::get('product/delete/{brandId}','ProductController@delete')->name('product.delete');
    Route::get('product/delete-image/{imageId}','ProductController@imageDelete')->name('product.imageDelete');
    /*brand*/

    Route::get('brand/list','BrandController@index')->name('brand.list');
    Route::get('brand/getlist','BrandController@getlist')->name('brand.getlist');
    Route::get('brand/add','BrandController@add')->name('brand.add');
    Route::get('brand/edit/{brandId}','BrandController@edit')->name('brand.edit');
    Route::post('brand/store','BrandController@store')->name('brand.store');
    Route::post('brand/update','BrandController@update')->name('brand.update');
    Route::get('brand/view/{brandId}','BrandController@viewDeal')->name('brand.view');
    Route::get('brand/delete/{brandId}','BrandController@delete')->name('brand.delete');

    /*brand*/

    Route::get('component/list','ComponentController@index')->name('component.list');
    Route::get('component/getlist','ComponentController@getlist')->name('component.getlist');
    Route::get('component/item','ComponentController@item')->name('component.item');
    Route::get('component/item/getItemList','ComponentController@getItemList')->name('component.getItemList');
    Route::get('component/item/add','ComponentController@itemAdd')->name('component.itemAdd');
    Route::post('component/item/store','ComponentController@itemStore')->name('component.itemStore');
    Route::get('component/item/edit/{itemId}','ComponentController@itemEdit')->name('component.itemEdit');
    Route::post('component/item/update','ComponentController@update')->name('component.update');
    Route::get('component/item/view/{itemId}','ComponentController@viewDeal')->name('component.itemView');
});


Route::group(['middleware' => ['auth','checkAdmin'],'prefix' => 'admin'], function() {
    Route::prefix('settings')->group(function (){
        Route::resource('categories', CategoryController::class);
    });
});

