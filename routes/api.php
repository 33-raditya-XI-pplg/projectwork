<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\SkemaController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/skema', [Api\SkemaController::class, 'show']);
Route::get('/event', [Api\EventController::class, 'show']);

Route::get('/shoow/{id}', [Api\SkemaController::class, 'shoow'])->name('shoow');
Route::get('/evshow/{id}', [Api\EventController::class, 'shoow'])->name('evshow');



// API Galeri start
Route::get('/galeri',[Api\Galeri\GaleriController::class,'index']);
Route::get('/galeri/{id}', [Api\Galeri\GaleriController::class, 'show']);
Route::post('/galeri', [Api\Galeri\GaleriController::class, 'store']);
Route::put('/galeri/{id}', [Api\Galeri\GaleriController::class, 'update']);
Route::delete('/galeri/{id}', [Api\Galeri\GaleriController::class, 'destroy']);

Route::get('/video',[Api\Galeri\VideoController::class,'index']);
Route::get('/video/{id}', [Api\Galeri\VideoController::class, 'show']);
Route::post('/video', [Api\Galeri\VideoController::class, 'store']);
Route::put('/video/{id}', [Api\Galeri\VideoController::class, 'update']);
Route::delete('/video/{id}', [Api\Galeri\VideoController::class, 'destroy']);
// API Galeri end

// API Partner Start
Route::get('/partner',[Api\Partner\PartnerController::class,'index']);
Route::get('/partner/{id}',[Api\Partner\PartnerController::class,'show']);
Route::post('/partner', [Api\Partner\PartnerController::class, 'store']);
Route::put('/partner/{id}', [Api\Partner\PartnerController::class, 'update']);
Route::delete('/partner/{id}', [Api\Partner\PartnerController::class, 'destroy']);
// API Partner End

// API Profil Start
Route::get('/profilecompany',[Api\ProfileCompany\ProfileCompanyController::class,'index']);
Route::get('/profilecompany/{id}',[Api\ProfileCompany\ProfileCompanyController::class,'show']);
Route::post('/profilecompany',[Api\ProfileCompany\ProfileCompanyController::class,'store']);
Route::put('/profilecompany/{id}',[Api\ProfileCompany\ProfileCompanyController::class,'update']);
Route::delete('/profilecompany/{id}',[Api\ProfileCompany\ProfileCompanyController::class,'destroy']);

// API Profil End




