<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TempatController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\RentangNilaiController;
use App\Http\Controllers\SkemaController;
use App\Http\Controllers\BackgroundController;
use App\Http\Controllers\JenisEventController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\EventController;

use App\Http\Controllers\PengujiController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\EventSkema;

use App\Http\Controllers\User\NilaiController;
use App\Http\Controllers\User\EventUsersController;
use App\Http\Controllers\User\SertifikatUsersController;
use App\Http\Controllers\User\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/',fn() => redirect('/login'));

Route::group(['prefix' => 'user', 'middleware' => 'auth'], function(){
    Route::resource('dashboard',DashboardController::class);
    Route::resource('nilai',NilaiController::class);
    Route::resource('event-user',EventUsersController::class);
    Route::resource('sertifikat-user',SertifikatUsersController::class);

});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){
    Route::get('/dashboard',fn() => view('admin.dashboard'))->name('dashboard');

    Route::resource('/event', EventController::class);
    Route::get('/event/skema/create', [EventSkema::class, 'create'])->name('event-skema.create');
    Route::get('/event/skema/{event}', [EventSkema::class, 'show'])->name('event-skema.show');
    Route::get('/event/rincian/{event}', [EventController::class, 'show'])->name('event.rincian');

    Route::get('penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');

    Route::group(['prefix' => 'master'], function () {
        Route::resource('tandatangan',SignatureController::class);
        Route::resource('skema', SkemaController::class);
        Route::resource('background', BackgroundController::class);
        Route::resource('/user', UserController::class);
        Route::resource('/penguji', PengujiController::class);
        Route::resource('/instansi', InstansiController::class);
        Route::resource('/jenis-event', JenisEventController::class);
        Route::resource('/tempat', TempatController::class);
        Route::resource('/rentang-nilai', RentangNilaiController::class);
    });
    Route::resource('sertifikat', SertifikatController::class);
    Route::resource('profile', ProfileController::class);

});

// AJAX Request
Route::get('penilaian/getEventData/{id}', [PenilaianController::class, 'getEventData']);
Route::get('penilaian/getSkemaData/{id}', [PenilaianController::class, 'getSkemaData']);

require __DIR__.'/auth.php';
