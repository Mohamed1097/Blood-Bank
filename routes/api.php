<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\AuthController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(["prefix"=>'v1',"namespace"=>"api"],function(){
    Route::get('governorates',[MainController::class, 'getGovernorates']);
    Route::get('cities',[MainController::class,'getCities'])->name('cities');
    Route::get('blood-types',[MainController::class,'getBloodTypes']);
    Route::get('settings',[MainController::class,'getSettings']);
    Route::get('messages',[MainController::class,'getMessages']);
    Route::post('add-setting',[MainController::class,'addSetting']);
    Route::post('register',[AuthController::class,'register']);
    Route::post('login',[AuthController::class,'login']);
    Route::post('send-pin-code',[AuthController::class,'sendPinCode']);
    Route::post('reset-password',[AuthController::class,"resetPassword"]);
    Route::group(['middleware' => 'auth:api'],function(){
        Route::get('posts',[MainController::class,'getPosts']); 
        Route::get('post',[MainController::class,'getPost']); 
        Route::get('notification-settings',[AuthController::class,'getNotificationSettings']);
        Route::post('edit-notification-settings',[AuthController::class,'editNotificationSettings']);
        Route::get('profile',[AuthController::class,'getProfile']);
        Route::post('edit-profile',[AuthController::class,'editProfile']); 
        Route::post('toggle-favourite',[AuthController::class,'toggleFavourite']);
        Route::get('favourites',[AuthController::class,'getFavourites']);
        Route::post('send-message',[MainController::class,'addMessage']);
        Route::get('logout',[AuthController::class,'logout']);
        Route::post('add-donation-request',[MainController::class,'addDonationRequest']);
        Route::get('donation-requests',[MainController::class,'getDonationRequests']);
        Route::get('get-donation-request',[MainController::class,'getDonationRequest']);
        Route::get('notifications',[MainController::class,'getNotifications']);
    });
});
