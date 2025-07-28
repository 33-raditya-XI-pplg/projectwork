<?php

use App\Http\Controllers\Api\Background\BackgroundController;
use App\Http\Controllers\Api\Instansi\InstansiController;
use App\Http\Controllers\Api\JenisEvt\JenisEventController;
use App\Http\Controllers\Api\Pengguna\PenggunaController;
use App\Http\Controllers\Api\Penguji\PengujiController;
use App\Http\Controllers\Api\PenilaianController;
use App\Http\Controllers\Api\sertifikatController;
use App\Http\Controllers\Api\Skema\SkemController;
use App\Http\Controllers\Api\TTD\TTDController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\SkemaController;
use App\Http\Controllers\BlogKategoriController;
use App\Http\Controllers\Api\Galeri\VideoController;
use App\Http\Controllers\Api\Slider\SliderController;
use App\Http\Controllers\Api\Partner\PartnerController;
use App\Http\Controllers\Api\Testimoni\TestimoniController;
use App\Http\Controllers\Api\ProfileCompany\ProfileCompanyController;
use App\Http\Controllers\Api\Tempat\TempatController;
use App\Http\Controllers\Api\Rentang\Rentang_nilaiController;

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

// Route::get('/skema', [Api\SkemaController::class, 'index']);
// Route::post('/skema', [Api\SkemaController::class, 'store']);
// Route::put('/skema/{id}', [Api\SkemaController::class, 'update'])->name('update');
// Route::delete('/skema/{id}', [Api\SkemaController::class, 'destroy']);
// Route::get('/skema/{id}', [Api\SkemaController::class, 'show'])->name('show');

Route::apiResource('skema', SkemaController::class);

Route::get('/event', [Api\EventController::class, 'show']);

Route::get('/evshow/{id}', [Api\EventController::class, 'shoow'])->name('evshow');
Route::post('/event', [Api\EventController::class, 'store'])->name('store');
Route::put('/event/{id}', [Api\EventController::class, 'update'])->name('update');
Route::delete('/event/{id}', [Api\EventController::class, 'destroy'])->name('destroy');

//Api Sertifikasi
Route::apiResource('sertifikat', sertifikatController::class);

//Api Penialaian
Route::apiResource('penilaian', PenilaianController::class);


// APi Tempat
Route::apiResource('tempat', TempatController::class);
// Api Instansi
Route::apiResource('instansi', InstansiController::class);
// Api Rentang_nilai
Route::apiResource('rentang', Rentang_nilaiController::class);
// Api Background
Route::apiResource('background', BackgroundController::class);
//Api TTD
Route::apiResource('ttd', TTDController::class);
//Api Skema
Route::apiResource('Skema', SkemController::class);
//Api JenisEvent
Route::apiResource('jenisEvt', JenisEventController::class);
//Api Pengguna
Route::apiResource('pengguna', PenggunaController::class);
//Api Penguji
Route::apiResource('penguji', PengujiController::class);


// API Galeri start
Route::get('/galeri', [Api\Galeri\GaleriController::class, 'index']);
Route::get('/galeri/{id}', [Api\Galeri\GaleriController::class, 'show']);
Route::post('/galeri', [Api\Galeri\GaleriController::class, 'store']);
Route::put('/galeri/{id}', [Api\Galeri\GaleriController::class, 'update']);
Route::delete('/galeri/{id}', [Api\Galeri\GaleriController::class, 'destroy']);

Route::get('/video', [Api\Galeri\VideoController::class, 'index']);
Route::get('/video/{id}', [Api\Galeri\VideoController::class, 'show']);
Route::post('/video', [Api\Galeri\VideoController::class, 'store']);
Route::put('/video/{id}', [Api\Galeri\VideoController::class, 'update']);
Route::delete('/video/{id}', [Api\Galeri\VideoController::class, 'destroy']);
// API Galeri end

// API Partner Start
Route::get('/partner', [Api\Partner\PartnerController::class, 'index']);
Route::get('/partner/{id}', [Api\Partner\PartnerController::class, 'show']);
Route::post('/partner', [Api\Partner\PartnerController::class, 'store']);
Route::put('/partner/{id}', [Api\Partner\PartnerController::class, 'update']);
Route::delete('/partner/{id}', [Api\Partner\PartnerController::class, 'destroy']);
// API Partner End

// API Profil Start
Route::get('/profilecompany', [Api\ProfileCompany\ProfileCompanyController::class, 'index']);
Route::get('/profilecompany/{id}', [Api\ProfileCompany\ProfileCompanyController::class, 'show']);
Route::post('/profilecompany', [Api\ProfileCompany\ProfileCompanyController::class, 'store']);
Route::put('/profilecompany/{id}', [Api\ProfileCompany\ProfileCompanyController::class, 'update']);
Route::delete('/profilecompany/{id}', [Api\ProfileCompany\ProfileCompanyController::class, 'destroy']);

// API Profil End


// API Testimoni Start
Route::get('/testimoni', [Api\Testimoni\TestimoniController::class, 'index']);
Route::get('/testimoni/{id}', [Api\Testimoni\TestimoniController::class, 'show']);
Route::post('/testimoni', [Api\Testimoni\TestimoniController::class, 'store']);
Route::put('/testimoni/{id}', [Api\Testimoni\TestimoniController::class, 'update']);
Route::delete('/testimoni/{id}', [Api\Testimoni\TestimoniController::class, 'destroy']);

// API Testimoni End


// Api Slide start
Route::get('/slider', [Api\Slider\SliderController::class, 'index']);
Route::get('/slider/{id}', [Api\Slider\SliderController::class, 'show']);
Route::post('/slider', [Api\Slider\SliderController::class, 'store']);
Route::put('/slider/{id}', [Api\Slider\SliderController::class, 'update']);
Route::delete('/slider/{id}', [Api\Slider\SliderController::class, 'destroy']);
// API slider End

//Blog kategori start
Route::get('/blogkategori', [Api\BlogKategori\BlogKategoriController::class, 'index']);
Route::get('/blogkategori/{id}', [Api\BlogKategori\BlogKategoriController::class, 'show']);
Route::post('/blogkategori', [Api\BlogKategori\BlogKategoriController::class, 'store']);
Route::put('/blogkategori/{id}', [Api\BlogKategori\BlogKategoriController::class, 'update']);
Route::delete('/blogkategori/{id}', [Api\BlogKategori\BlogKategoriController::class, 'destroy']);


//Blog kategori end


// Kategor start
Route::get('/kategori', [Api\Kategori\KategoriController::class, 'index']);
Route::get('/kategori/{id}', [Api\Kategori\KategoriController::class, 'show']);
Route::post('/kategori', [Api\Kategori\KategoriController::class, 'store']);
Route::put('/kategori/{id}', [Api\Kategori\KategoriController::class, 'update']);
Route::delete('/kategori/{id}', [Api\Kategori\KategoriController::class, 'destroy']);

// kategori end


// faq start
Route::get('/faq', [Api\Faq\FaqController::class, 'index']);
Route::get('/faq/{id}', [Api\Faq\FaqController::class, 'show']);
Route::post('/faq', [Api\Faq\FaqController::class, 'store']);
Route::put('/faq/{id}', [Api\Faq\FaqController::class, 'update']);
Route::delete('/faq/{id}', [Api\Faq\FaqController::class, 'destroy']);

// faq end


// blog start
Route::get('/blog', [Api\Blog\BlogController::class, 'index']);
Route::get('/blog/{id}', [Api\Blog\BlogController::class, 'show']);
Route::post('/blog', [Api\Blog\BlogController::class, 'store']);
Route::put('/blog/{id}', [Api\Blog\BlogController::class, 'update']);
Route::delete('/blog/{id}', [Api\Blog\BlogController::class, 'destroy']);
//blog end


// page start
Route::get('/page', [Api\Page\PageController::class, 'index']);
Route::get('/page/{id}', [Api\Page\PageController::class, 'show']);
Route::post('/page', [Api\Page\PageController::class, 'store']);
Route::put('/page/{id}', [Api\Page\PageController::class, 'update']);
Route::delete('/page/{id}', [Api\Page\PageController::class, 'destroy']);
// page end

Route::get('/get-peserta-data', [App\Http\Controllers\LaporanController::class, 'fetchPesertaData'])->name('fetch.peserta.data');



