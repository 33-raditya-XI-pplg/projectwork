<?php



use App\Http\Controllers\User\TestimoniUserController;
use App\Http\Controllers\UploadPembayaranController;
use App\Models\Upload_pembayaran;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SkemaController;
use App\Http\Controllers\VideoController;

use App\Http\Controllers\GaleriController;
use App\Http\Controllers\TempatController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\PartnerController;

use App\Http\Controllers\PengujiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InstansiController;




use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\SignatureController;
use App\Http\Controllers\BackgroundController;
use App\Http\Controllers\EventSkemaController;
use App\Http\Controllers\JenisEventController;
use App\Http\Controllers\SertifikatController;

use App\Http\Controllers\RentangNilaiController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\EventUsersController;
use App\Http\Controllers\ProfilPerusahaanController;
use App\Http\Controllers\User\RincianSkemaController;
use App\Http\Controllers\User\SertifikatUsersController;

use App\Http\Controllers\BlogKategoriController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\LaporanPerkembanganController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => redirect('/login'));

Route::group(['prefix' => 'user', 'middleware' => ['auth', 'checkRole:Pengguna']], function () {
    Route::get('dashboard', [DashboardController::class, 'user_index']);
    Route::resource('event-user', EventUsersController::class);
    Route::resource('sertifikat-user', SertifikatUsersController::class);
    Route::get('event-user/rincian-skema/{event_skemaID}', [RincianSkemaController::class, 'rincian_skema'])->name('event.rincian-skema');
    Route::get('sertifikat-user/rincian-skema/{event_skemaID}', [RincianSkemaController::class, 'rincian_skema'])->name('sertifikat.rincian-skema');

    Route::get('cetak-sertifikat/{event_skemaID}', [SertifikatUsersController::class, 'cetak'])->name('cetak-sertifikat.cetak');
    Route::get('cetak-sertifikat', [SertifikatUsersController::class, 'cetak1']);
    Route::post('event-user/mendaftar', [EventUsersController::class, 'mendaftar'])->name('mendaftar.event');

    Route::resource('uploadPembayaran-user', UploadPembayaranController::class);

    Route::resource('testimoni-user', TestimoniUserController::class)->except(['show']);
    Route::get('testimoni-user/{id}/detail', [TestimoniUserController::class, 'show'])->name('testimoni-user.show');


    //profile
    Route::resource('profile-user', ProfileController::class)->except(['edit', 'show'])->names(['profile-user', 'profile-user.update']);
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit-user');

});

Route::group(['prefix' => 'penguji', 'middleware' => ['auth', 'checkRole:Penguji']], function () {
    Route::get('dashboard', [DashboardController::class, 'user_index']);
    // Route::resource('event', EventUsersController::class);
    // Route::resource('sertifikat', SertifikatUsersController::class);
    // Route::get('event-user/rincian-skema/{event_skemaID}', [RincianSkemaController::class, 'rincian_skema'])->name('event.rincian-skema');
    // Route::get('sertifikat-user/rincian-skema/{event_skemaID}', [RincianSkemaController::class, 'rincian_skema'])->name('sertifikat.rincian-skema');

    // Route::get('cetak-sertifikat/{event_skemaID}', [SertifikatUsersController::class, 'cetak'])->name('cetak-sertifikat.cetak');
    // Route::get('cetak-sertifikat', [SertifikatUsersController::class, 'cetak1']);
    // Route::post('event-user/mendaftar', [EventUsersController::class, 'mendaftar'])->name('mendaftar.event');

    //profile
    Route::resource('profile-penguji', ProfileController::class)->except(['edit', 'show'])->names(['profile-penguji', 'profile-penguji.update']);
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit-penguji');

});

Route::group(['previx' => 'penguji', 'middleware' => 'auth'], function () {
    Route::resource('profile', ProfileController::class)->except(['edit', 'show']);
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'checkRole:Admin']], function () {

    //dashboard
    Route::get('dashboard', [DashboardController::class, 'admin_index']);

    //event
    Route::resource('/event', EventController::class);
    Route::get('/event/{event}/rincian/', [EventController::class, 'show'])->name('event.rincian');
    Route::get('/event/{event}/skema/index/', [EventSkemaController::class, 'index'])->name('event-skema.index');
    Route::get('/event/{event}/skema/create/', [EventSkemaController::class, 'create'])->name('event-skema.create');
    Route::get('/event/{event}/skema/{skema}/edit/', [EventSkemaController::class, 'edit'])->name('event-skema.edit');
    Route::get('/event/{event}/skema/{skema}/rincian', [EventSkemaController::class, 'show'])->name('event-skema.show');
    Route::get('/event/{event}/skema/{skema}/add-student', [EventSkemaController::class, 'addStudent'])->name('event-skema.add');
    Route::post('/event/{event}/skema/', [EventSkemaController::class, 'store'])->name('event-skema.store');
    Route::delete('/event/{event}/skema/{skema}', [EventSkemaController::class, 'destroy'])->name('event-skema.delete');
    Route::put('/event/{event}/skema/{skema}', [EventSkemaController::class, 'update'])->name('event-skema.update');
    Route::post('/event/{event}/skema/{skema}/students', [EventSkemaController::class, 'storeStudents'])->name('event-skema.store-student');
    Route::delete('/event/skema/{skema}/students/{id}', [EventSkemaController::class, 'destroyStudents'])->name('event-skema.delete-student');

    //Laporan perkembangan
    Route::resource('/laporanperkembangan', LaporanPerkembanganController::class);


    //penilaian
    Route::resource('/penilaian', PenilaianController::class);

    //sertifikat
    Route::resource('sertifikat', SertifikatController::class);

    Route::resource('uploadPembayaran', UploadPembayaranController::class);
    Route::put('/update-status/{id_upload_pembayaran}', [UploadPembayaranController::class, 'updateStatus'])->name('upload.updateStatus');


    Route::group(['prefix' => 'master'], function () {
        Route::resource('tandatangan', SignatureController::class)->except(['show']);
        Route::get('tandatangan/{id}/detail', [SignatureController::class, 'show'])->name('tandatangan.show');
        Route::resource('skema', SkemaController::class)->except(['show']);
        Route::get('skema/{id}/detail', [SkemaController::class, 'show'])->name('skema.show');
        Route::resource('background', BackgroundController::class)->except(['show']);
        Route::get('background/{id}/detail', [BackgroundController::class, 'show'])->name('background.show');
        Route::resource('/user', UserController::class)->except(['show']);
        Route::get('/user{id}/detail', [UserController::class, 'show'])->name('user.show');
        Route::post('user/update-status/{id}', [UserController::class, 'updateStatus'])->name('user.updateStatus');
        Route::post('user/import', [UserController::class, 'import'])->name('user.import');
        Route::resource('/penguji', PengujiController::class)->except(['show']);
        Route::get('penguji/{id}/detail', [PengujiController::class, 'show'])->name('penguji.show');
        Route::post('/penguji/update-status/{id}', [PengujiController::class, 'updateStatus'])->name('penguji.updateStatus');

        Route::resource('/instansi', InstansiController::class)->except(['show']);
        Route::get('/instansi/{id}/detail', [InstansiController::class, 'show'])->name('instansi.show');
        Route::resource('/jenis-event', JenisEventController::class)->except(['show']);
        Route::get('/jenis-event/{id}/detail', [JenisEventController::class, 'show'])->name('jenis-event.show');
        Route::resource('/tempat', TempatController::class)->except(['show']);
        Route::get('/tampat/{id}/detail', [TempatController::class, 'show'])->name('tempat.show');
        Route::resource('/rentang-nilai', RentangNilaiController::class);
    });

    Route::group(['prefix' => 'management'], function () {
        //galeri
        Route::resource('galeri', GaleriController::class);
        Route::get('/galeri', [GaleriController::class, 'index'])->name('index');
        Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');
        Route::get('/create', [GaleriController::class, 'create'])->name('galeri.create');
        Route::post('/store', [GaleriController::class, 'store'])->name('galeri.store');
        Route::get('/show', [GaleriController::class, 'show'])->name('galeri.show');
        Route::get('galeri/{id}/edit', [GaleriController::class, 'edit'])->name('galeri.edit');
        Route::put('galeri/{id}', [GaleriController::class, 'update'])->name('galeri.update');
        Route::delete('/galeri/{id}', [GaleriController::class, 'destroy'])->name('galeri.destroy');

        //kategori
        Route::get('/kategori/{kategori}/detail', [KategoriController::class, 'show'])->name('kategori.show');
        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.indek');
        Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
        Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/admin/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

        //video
        Route::get('/video', [VideoController::class, 'index'])->name('video.index');
        Route::post('/video/store', [VideoController::class, 'store'])->name('video.store');
        Route::get('/video/create', [VideoController::class, 'create'])->name('video.create');
        Route::get('/video/{id}', [VideoController::class, 'show'])->name('video.show');
        Route::get('/video/{id}/edit', [VideoController::class, 'edit'])->name('video.edit');
        Route::delete('/video/{id}', [VideoController::class, 'destroy'])->name('video.destroy');
        Route::get('/video/{id}/edit', [VideoController::class, 'edit'])->name('video.edit');
        Route::put('/video/{id}', [VideoController::class, 'update'])->name('video.update');
        Route::delete('/video/{id}', [VideoController::class, 'destroy'])->name('video.destroy');

        //page
        Route::get('/page/{page}/detail', [PageController::class, 'show'])->name('page.show');
        Route::get('/page', [PageController::class, 'index'])->name('page.index');
        Route::post('/page', [PageController::class, 'store'])->name('page.store');
        Route::put('/page/{id}', [PageController::class, 'update'])->name('page.update');
        Route::delete('/admin/pages/{id}', [PageController::class, 'destroy'])->name('page.destroy');
        Route::put('/admin/page/{id}', [PageController::class, 'update'])->name('page.update');
        Route::get('/admin/page/{id}/edit', [PageController::class, 'edit'])->name('page.edit');

        // blog 

        // Route::resource('/blog', BlogController::class);
        Route::get('/blog', [BlogController::class, 'index'])->name('blog.indek');
        Route::post('/blog', [BlogController::class, 'store'])->name('blog.store');
        Route::put('/blog/{id}', [BlogController::class, 'update'])->name('blog.update');
        Route::delete('/blog/{id}', [BlogController::class, 'destroy'])->name('blog.destroy');
        Route::put('/blog/{id}', [BlogController::class, 'update'])->name('blog.update');
        Route::get('/blog/{id}/detail', [BlogController::class, 'show'])->name('blog.show');

        // Profile perusahaan
        Route::get('/profil/{profil}/detail', [ProfilPerusahaanController::class, 'rincian'])->name('profil.rincian');
        Route::get('/profil', [ProfilPerusahaanController::class, 'index'])->name('profil.index');
        Route::post('/profil', [ProfilPerusahaanController::class, 'store'])->name('profil.store');
        Route::put('/profil/{id}', [ProfilPerusahaanController::class, 'update'])->name('profil.update');
        Route::delete('/profil/{id}', [ProfilPerusahaanController::class, 'destroy'])->name('profil.destroy');

        // Route::get('/blogkategori', [BlogKategoriController::class, 'index'])->name('blogkategori.index');
        // Route::post('/blogkategori', [BlogKategoriController::class, 'store'])->name('blogkategori.store');
        // // Correct route for updating blogkategori
        // Route::put('/blogkategori/{id}', [BlogKategoriController::class, 'update'])->name('blogkategori.update');
        // Route::delete('/blogkategori/{id_blog_kategori}', [BlogKategoriController::class, 'destroy'])->name('blogkategori.destroy');

        // Partner
        Route::get('/partner', [PartnerController::class, 'index'])->name('partner.index');
        Route::post('/partner', [PartnerController::class, 'store'])->name('partner.store');
        Route::put('/partner/{id}', [PartnerController::class, 'update'])->name('partner.update');
        Route::delete('/partner/{partner}', [PartnerController::class, 'destroy'])->name('partner.destroy');
        Route::get('/partner/{partner}/detail', [PartnerController::class, 'show'])->name('partner.rincian');

        //testimoni
        Route::get('/testimoni', [TestimoniController::class, 'index'])->name('testimoni.indek');
        Route::post('/testimoni', [TestimoniController::class, 'store'])->name('testimoni.store');
        Route::put('/testimoni{testimoni}', [TestimoniController::class, 'update'])->name('testimoni.update');
        Route::get('/testimoni/{testimoni}/detail', [TestimoniController::class, 'show'])->name('testimoni.show');
        Route::delete('/testimoni{testimoni}', [TestimoniController::class, 'destroy'])->name('testimoni.destroy');


        //slider
        Route::get('/slider/{slider}/detail', [SliderController::class, 'show'])->name('slider.show');
        Route::get('/slider', [SliderController::class, 'index'])->name('slider.indek');
        Route::post('/slider', [SliderController::class, 'store'])->name('slider.store');
        Route::put('/slider{slider}', [SliderController::class, 'update'])->name('slider.update');
        Route::delete('/slider{slider}', [SliderController::class, 'destroy'])->name('slider.destroy');

        //faq
        Route::get('/faq', [FaqController::class, 'index'])->name('faq.indek');
        Route::post('/faq', [FaqController::class, 'store'])->name('faq.store');
        Route::put('/faq/{id}', [FaqController::class, 'update'])->name('faq.update');
        Route::get('/faq/{id}/detail', [FaqController::class, 'show'])->name('faq.show');
        Route::delete('/admin/faq/{id}', [FaqController::class, 'destroy'])->name('faq.destroy');
    });

    //profile
    Route::resource('profile', ProfileController::class)->except(['edit', 'show']);
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    // jquery
    Route::get('/peserta/instansi/{instansi}/event-skema/{skema}', [EventSkemaController::class, 'search'])->name('getPeserta');

});
Route::get('/getSkema/{id_event}', [UploadPembayaranController::class, 'getSkema']);

// AJAX Request -- Menu Laporan 
Route::get('/laporanperkembangan/fetchEventData/{id}', [LaporanPerkembanganController::class, 'fetchEventData']);
Route::get('laporanperkembangan/fetchSkemaData/{id}', [LaporanperkembanganController::class, 'fetchSkemaData']);
Route::get('laporanperkembangan/fetchPesertaData/{id}', [LaporanperkembanganController::class, 'fetchPesertaData']);
Route::post('laporanperkembangan/storeNilaiData/{id}', [LaporanperkembanganController::class, 'storeNilaiData']);
Route::get('laporanperkembangan/fetchLaporanData/{id}', [LaporanperkembanganController::class, 'fetchLaporanData']);
Route::post('/laporanperkembangan/updateLaporan/{id}', [LaporanPerkembanganController::class, 'update']);
Route::delete('/laporanperkembangan/destroyLaporanData/{id}', [LaporanPerkembanganController::class, 'destroyLaporanData']);
// AJAX Request -- Menu Penilaian
Route::get('penilaian/fetchEventData/{id}', [PenilaianController::class, 'fetchEventData']);
Route::get('penilaian/fetchSkemaData/{id}', [PenilaianController::class, 'fetchSkemaData']);
Route::get('penilaian/fetchPesertaData/{id}', [PenilaianController::class, 'fetchPesertaData']);
Route::get('penilaian/fetchNilaiData/{id}', [PenilaianController::class, 'fetchNilaiData']);
Route::get('penilaian/fetchInisialData', [PenilaianController::class, 'fetchInisialData']);

Route::post('penilaian/storeNilaiData', [PenilaianController::class, 'storeNilaiData']);
Route::delete('penilaian/destroyNilaiData/{id}', [PenilaianController::class, 'destroyNilaiData']);

// AJAX Request -- Menu Sertifikat
Route::get('sertifikat/fetchPesertaData/{id}', [SertifikatController::class, 'fetchPesertaData']);
Route::get('sertifikat/fetchSertifikatData/{id}', [SertifikatController::class, 'fetchSertifikatData']);
Route::get('sertifikat/showSertifikat/{id}/pdf', [SertifikatController::class, 'showSertifikat']);
Route::get('sertifikat/checkSertifikat/{part1}/{part2}/{part3}/{part4}/{part5}', [SertifikatController::class, 'checkSertifikat']);

Route::post('/exportToPDF', [SertifikatController::class, 'exportToPDF'])->name('exportToPDF');
Route::post('sertifikat/storeSertifikatData', [SertifikatController::class, 'storeSertifikatData']);
Route::post('sertifikat/updateSertifikatData', [SertifikatController::class, 'updateSertifikatData']);
Route::delete('sertifikat/destroySertifikatData/{id}', [SertifikatController::class, 'destroySertifikatData']);

require __DIR__ . '/auth.php';
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::post('/blog', [BlogController::class, 'store'])->name('blog.store');
Route::put('/blog/{id}', [BlogController::class, 'update'])->name('blog.update');
Route::delete('/blog/{id}', [BlogController::class, 'destroy'])->name('blog.destroy');
Route::put('/admin/blog/{id}', [BlogController::class, 'update'])->name('blog.update');
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
Route::post('/faq', [FaqController::class, 'store'])->name('faq.store');
Route::put('/faq/{id}', [FaqController::class, 'update'])->name('faq.update');
Route::delete('/admin/faq/{id}', [FaqController::class, 'destroy'])->name('faq.destroy');
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/admin/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
Route::get('/testimoni', [TestimoniController::class, 'index'])->name('testimoni.index');
Route::post('/testimoni', [TestimoniController::class, 'store'])->name('testimoni.store');
Route::put('/testimoni{testimoni}', [TestimoniController::class, 'update'])->name('testimoni.update');
Route::delete('/testimoni{testimoni}', [TestimoniController::class, 'destroy'])->name('testimoni.destroy');
Route::get('/slider', [SliderController::class, 'index'])->name('slider.index');
Route::post('/slider', [SliderController::class, 'store'])->name('slider.store');
Route::put('/slider{slider}', [SliderController::class, 'update'])->name('slider.update');
Route::delete('/slider{slider}', [SliderController::class, 'destroy'])->name('slider.destroy');
Route::get('/get-email/{nama}', [TestimoniController::class, 'getEmail'])->name('getEmail');
Route::post('/testimoni-user', [TestimoniUserController::class, 'store'])->name('testimoni-user.store');
Route::get('/testimoni-user', [TestimoniUserController::class, 'index'])->name('testimoni-user.indek');
Route::put('/testimoni-user/{testimoni}', [TestimoniUserController::class, 'update'])->name('testimoni-user.update');
// Route::get('/testimoni-user/{testimoni}', [TestimoniUserController::class, 'show'])->name('testimoni-user.show');

