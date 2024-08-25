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
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\TestimoniController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\KurirController;
use App\Http\Controllers\ProfilPenggunaController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\RegisterMemberController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\VisitorController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/informasi', [HomeController::class, 'informasi']);
Route::get('/informasi/{slug}', [HomeController::class, 'informasi_detail'])->name('informasi.informasi_detail');
Route::get('/kurir_page', [HomeController::class, 'kurir_page']);
// Web.php
Route::get('/kurir_page/{id}', [HomeController::class, 'getKurir']);

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
Route::get('/daftar_member', [RegisterMemberController::class, 'showRegistrationForm'])->name('daftar_member.index');
Route::post('/daftar_member', [RegisterMemberController::class, 'register'])->name('daftar_member.register');
Route::resource('log_histori', LogHistoriController::class);





// Route::get('produk/datatables', [ProdukController::class, 'index'])->name('produk.datatables');
Route::get('datatables/produk', [ProdukController::class, 'getProdukDatatables'])->name('datatables.produk');
Route::resource('produk', ProdukController::class);


Route::get('/auth/redirect', [SocialiteController::class, 'redirect']);
Route::get('/auth/google/callback', [SocialiteController::class, 'callback']);

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout')->middleware('auth');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store')->middleware('auth');
Route::get('/checkout/cities', [CheckoutController::class, 'getCities']);
Route::get('/checkout/cost', [CheckoutController::class, 'getCost']);


Route::middleware(['auth', 'checkRole:administrator'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('kategori_produk', KategoriProdukController::class);
    // Log History
    Route::get('/log-histori/delete-all', [LogHistoriController::class, 'deleteAll'])->name('log-histori.delete-all');
    Route::get('/visitor/delete-all', [VisitorController::class, 'deleteAll'])->name('visitor.delete-all');
    Route::get('/visitor_toko/delete-all', [VisitorController::class, 'deleteAllvisitor_toko'])->name('visitor_toko.delete-all');

    Route::get('/backup', [BackupController::class, 'createBackup'])->name('backup.create');

    // Profil Perusahaan
    Route::resource('profil', ProfilController::class)->middleware('auth');
    Route::put('/profil/update_media_sosial/{id}', [ProfilController::class, 'update_media_sosial'])->name('profil.update_media_sosial');
    Route::put('/profil/update_umum/{id}', [ProfilController::class, 'update_umum'])->name('profil.update_umum');
    Route::put('/profil/update_sdm/{id}', [ProfilController::class, 'update_sdm'])->name('profil.update_sdm');
    Route::put('/profil/update_display/{id}', [ProfilController::class, 'update_display'])->name('profil.update_display');
    Route::put('/profil/update_syarat/{id}', [ProfilController::class, 'syarat'])->name('profil.update_syarat');

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

    // Testimoni
    Route::resource('kurir', KurirController::class);

    // Video
    Route::resource('video', VideoController::class);

    // Info
    Route::resource('info', InformasiController::class);
    Route::resource('transaksi', TransaksiController::class);
    Route::resource('visitor', VisitorController::class);
});

// Route untuk pengguna biasa
Route::middleware(['auth', 'checkRole:administrator|pengguna'])->group(function () {

    Route::resource('/dashboard', DashboardController::class)->names([
        'index' => 'dashboard.index',
        'create' => 'dashboard.create',
        'store' => 'dashboard.store',
        'show' => 'dashboard.show',
        'edit' => 'dashboard.edit',
        'update' => 'dashboard.update',
        'destroy' => 'dashboard.destroy',
    ]);
    Route::resource('profil_pengguna', ProfilPenggunaController::class)->middleware('auth');
    Route::put('/profil_pengguna/update_pengguna/{id}', [ProfilPenggunaController::class, 'update_pengguna'])->name('profil.update_pengguna');
    Route::put('/profil_pengguna/update_display_pengguna/{id}', [ProfilPenggunaController::class, 'update_display_pengguna'])->name('profil.update_display_pengguna');
    Route::get('visitor_toko', [VisitorController::class, 'index2'])->name('visitor.index2');
    Route::get('/visitor_toko/delete-all2', [VisitorController::class, 'deleteVisitorPengguna'])->name('visitor_toko.delete-all2');
});



// Route untuk semua role
// Route::get('visitor_toko', [VisitorController::class, 'index2'])->name('visitor.index2');
Route::get('/auth', [AuthController::class, 'index'])->name('auth');
Route::post('/auth', [AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');

// tes
