<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\GovernorateController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DonationRequestController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Auth;
use App\Http\controllers\RoleController;
use App\Http\controllers\UserController;
use App\Http\Controllers\front\AuthController;
use App\Http\Controllers\front\MainController;

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
// Route::get('login',[LoginController::class,'showClientLoginForm']);
// Route::get('/',[MainController::class,'home'])->name('main');
// Route::group(['namespace'=>'front','middleware'=>'auth:web-client'],function(){
    
// }
// );

Auth::routes();
Route::group(['namespace'=>'front'],function(){
    Route::name('client.')->group(function(){
  
        Route::middleware(['guest:web-client','PreventBackHistory'])->group(function(){
              Route::view('login','front.login',['title'=>'Login'])->name('login');
              Route::post('check',[AuthController::class,'check'])->name('check');
              Route::view('register', 'front.register',['title'=>'Create New Account'])->name('register');
        });
    
        Route::middleware(['auth:web-client','PreventBackHistory'])->group(function(){
              Route::get('/',[MainController::class,'home'])->name('home');
              Route::post('toggle-fav', [MainController::class,'toggleFavourite'])->name('toggle-favourite');
              Route::post('/logout',[AuthController::class,'logout'])->name('logout');
        });
    
    });
});



Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest:web','PreventBackHistory'])->group(function(){
        Route::view('/login','auth.login')->name('login');
        Route::post('/check',[UserController::class,'check'])->name('check');
  });
    Route::middleware(['auth','auto-check-permission','PreventBackHistory'])->group(function () 
    {
        Route::post('/logout',[UserController::class,'logout'])->name('logout');
        Route::get('/set-new-password',[UserController::class,'changePassword'])->name('change-password');
        Route::post('update-password',[UserController::class,'updatePassword'])->name('set-password');
        Route::get('/',[HomeController::class,'index'])->name('home');
        Route::resource('/governorate', GovernorateController::class);
        Route::resource('/cities', CityController::class);
        Route::resource('/post-categories', PostCategoryController::class);
        Route::resource('post', PostController::class);
        Route::resource('/clients', ClientController::class);
        Route::resource('/donation-requests', DonationRequestController::class);
        Route::resource('/settings', SettingController::class);
        Route::resource('/messages', ContactController::class);
        Route::resource('/roles', RoleController::class);
        Route::resource('/users', UserController::class); 
       
    });
});




