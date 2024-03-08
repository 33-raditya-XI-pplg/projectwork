<?php

use App\Http\Controllers\BackgroundController;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PengujiController;
use App\Http\Controllers\InstansiController;

use App\Http\Controllers\SchemeController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',function(){
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function(){
    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    });

    Route::resource('/event', EventController::class);

    Route::group(['prefix' => 'master'], function () {
        Route::resource('signature',SignatureController::class);
        Route::resource('scheme', SchemeController::class);
        Route::resource('background', BackgroundController::class);
        Route::resource('/user', UserController::class);
        Route::resource('/penguji', PengujiController::class);
        Route::resource('/instansi', InstansiController::class);
    });


});

require __DIR__.'/auth.php';
