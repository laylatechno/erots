<?php

use App\Http\Controllers\AlasanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\KategoriBeritaController;
use App\Http\Controllers\KategoriGaleriController;
use App\Http\Controllers\KategoriProdukController;
use App\Http\Controllers\LogHistoriController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\BbptuController;
use App\Http\Controllers\BbuController;
use App\Http\Controllers\GiziController;
use App\Http\Controllers\HasilHitungController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImtController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PtbuController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\ProfilPenggunaController;
use App\Http\Controllers\RegisterController;

// Redirect Home jika dia Guest
// Route::get('/home', function () {
//     return redirect('/dashboard');
// });



Route::get('/', [HomeController::class, 'index']);
Route::get('/informasi', [HomeController::class, 'informasi']);
Route::get('/informasi/{slug}', [HomeController::class, 'informasi_detail'])->name('informasi.informasi_detail');
Route::get('/produk_sale', [HomeController::class, 'produk_sale'])->name('produk_sale');
Route::get('/produk_sale/{slug}', [HomeController::class, 'produk_sale_detail'])->name('produk_sale.produk_sale_detail');
Route::get('/toko', [HomeController::class, 'toko'])->name('toko');
Route::get('/toko/{user}', [HomeController::class, 'toko_detail'])->name('toko.toko_detail');
Route::get('/video_pengguna', [HomeController::class, 'video']);
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/delete/{id}', [CartController::class, 'delete'])->name('cart.delete');
Route::get('/cart/reset', [CartController::class, 'reset'])->name('cart.reset');
Route::get('/daftar', [RegisterController::class, 'showRegistrationForm'])->name('daftar.index');
Route::post('/daftar', [RegisterController::class, 'register'])->name('daftar.register');
Route::resource('log_histori', LogHistoriController::class);


// Route::resource('/dashboard', DashboardController::class);
// Route::resource('users', UserController::class);
Route::resource('/dashboard', DashboardController::class);
Route::resource('profil_pengguna', ProfilPenggunaController::class)->middleware('auth');
Route::put('/profil_pengguna/update_pengguna/{id}', [ProfilPenggunaController::class, 'update_pengguna'])->name('profil.update_pengguna');
// Produk
Route::resource('kategori_produk', KategoriProdukController::class);
// Route::get('produk/datatables', [ProdukController::class, 'index'])->name('produk.datatables');
Route::get('datatables/produk', [ProdukController::class, 'getProdukDatatables'])->name('datatables.produk');
Route::resource('produk', ProdukController::class);



Route::middleware(['auth', 'checkRole:administrator'])->group(function () {
    Route::resource('users', UserController::class);

    // Log History
    Route::get('/log-histori/delete-all', [LogHistoriController::class, 'deleteAll'])->name('log-histori.delete-all');
    Route::get('/backup', [BackupController::class, 'createBackup'])->name('backup.create');

    // Profil Perusahaan
    Route::resource('profil', ProfilController::class)->middleware('auth');
    Route::put('/profil/update_media_sosial/{id}', [ProfilController::class, 'update_media_sosial'])->name('profil.update_media_sosial');
    Route::put('/profil/update_umum/{id}', [ProfilController::class, 'update_umum'])->name('profil.update_umum');
    Route::put('/profil/update_sdm/{id}', [ProfilController::class, 'update_sdm'])->name('profil.update_sdm');
    Route::put('/profil/update_display/{id}', [ProfilController::class, 'update_display'])->name('profil.update_display');

    // Berita
    Route::resource('kategori_berita', KategoriBeritaController::class);
    Route::resource('berita', BeritaController::class);

    // Galeri
    Route::resource('kategori_galeri', KategoriGaleriController::class);
    Route::resource('galeri', GaleriController::class);

    // Slider
    Route::resource('slider', SliderController::class);

    // Layanan
    Route::resource('layanan', LayananController::class);

    // Alasan
    Route::resource('alasan', AlasanController::class);

    // Testimoni
    Route::resource('testimoni', TestimoniController::class);

    // Video
    Route::resource('video', VideoController::class);

    // Info
    Route::resource('info', InformasiController::class);
});

// Route untuk pengguna biasa
Route::middleware(['auth', 'checkRole:pengguna'])->group(function () {
});


// Route untuk semua role
Route::get('/auth', [AuthController::class, 'index'])->name('auth');
Route::post('/auth', [AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
