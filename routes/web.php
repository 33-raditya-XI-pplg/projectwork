<?php


use App\Http\Controllers\SignatureController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){
    Route::get('/dashboard', function() {
        return view('admin.dashboard');
    });
    Route::resource('signature',SignatureController::class);
});
require __DIR__.'/auth.php';
