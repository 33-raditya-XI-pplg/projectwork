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
use App\Http\Controllers\EventSkemaController;

use App\Http\Controllers\User\NilaiController;
use App\Http\Controllers\User\EventUsersController;
use App\Http\Controllers\User\SertifikatUsersController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\RincianController;
use App\Http\Controllers\User\RincianNilaiController;
use App\Http\Controllers\User\RincianSertifikatController;

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
    Route::resource('rincian-user',RincianController::class);
    Route::resource('rincian-sertifikat',RincianSertifikatController::class);
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){
    Route::get('/dashboard',fn() => view('admin.dashboard'))->name('dashboard');

    Route::resource('/event', EventController::class);
    Route::resource('/penilaian', PenilaianController::class);

    Route::get('/event/{event}/skema/create/', [EventSkemaController::class, 'create'])->name('event-skema.create');
    Route::get('/event/{event}/skema/{skema}/edit/', [EventSkemaController::class, 'edit'])->name('event-skema.edit');
    Route::get('/event/skema/{event}', [EventSkemaController::class, 'show'])->name('event-skema.show');
    Route::post('/event/skema/', [EventSkemaController::class, 'store'])->name('event-skema.store');
    Route::delete('/event/{event}/skema/{skema}', [EventSkemaController::class, 'destroy'])->name('event-skema.delete');
    Route::put('/event/skema/{skema}', [EventSkemaController::class, 'update'])->name('event-skema.update');

    Route::get('/event/{event}/rincian/', [EventController::class, 'show'])->name('event.rincian');

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
Route::get('penilaian/fetchEventData/{id}', [PenilaianController::class, 'fetchEventData']);
Route::get('penilaian/fetchSkemaData/{id}', [PenilaianController::class, 'fetchSkemaData']);
Route::get('penilaian/fetchPesertaData/{id}', [PenilaianController::class, 'fetchPesertaData']);
Route::get('penilaian/fetchNilaiData/{id}', [PenilaianController::class, 'fetchNilaiData']);
Route::post('penilaian/storeNilaiData', [PenilaianController::class, 'storeNilaiData']);

require __DIR__.'/auth.php';
