<?php

use App\Http\Controllers\TandatanganController;
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

Route::get('/', function () {
    return view('welcome');
});

//event
Route::resource('ttd',TandatanganController::class);


// route khusus admin
// Route::group(['prefix' => 'admin'], function() {
//     Route::get('/dashboard', function() {
//         return view('admin.dashboard');
//     });
// });
