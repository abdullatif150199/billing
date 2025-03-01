<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\PaketLanggananController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\AreaAlamatController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomerServiceController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\MikrotikController;
use App\Http\Controllers\Pelanggan\RiwayatPembayaranController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PengajuanTagihanController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatusKoneksiServerController;
use App\Http\Controllers\SubTagihanController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\VerifikasiPembayaranKoordinatorController;

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

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'view'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    // KASIR / KOORDINATOR
    Route::middleware(['role:koordinator'])->group(function () {
        Route::prefix('/pengajuan')->name('pengajuan.')->group(function () {
            Route::get('/', [PengajuanTagihanController::class, 'index'])->name('index');
            Route::post('/ajukan/{tagihan}', [PengajuanTagihanController::class, 'store'])->name('store');
            Route::post('/ajukan-ulang/{pembayaran}', [PengajuanTagihanController::class, 'reStore'])->name('reStore');
        });

        Route::get('/koordinator/customer-service', CustomerServiceController::class)->name('customer-service-koordinator.index');

        Route::name('profile.')->prefix('/profile')->group(function () {
            Route::post('/koordinator', [ProfileController::class, 'updateKoordinator'])->name('update-koordinator');
        });
    });

    // PELANGGAN
    Route::middleware(['role:pelanggan'])->group(function () {
        Route::get('/riwayat-pembayaran', RiwayatPembayaranController::class)->name('riwayat-pembayaran');

        Route::get('/pelanggan/customer-service', CustomerServiceController::class)->name('customer-service-pelanggan.index');

        Route::name('profile.')->prefix('/profile')->group(function () {
            Route::post('/pelanggan', [ProfileController::class, 'updatePelanggan'])->name('update-pelanggan');
        });
    });

    // ADMIN
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('/pelanggan', PelangganController::class)->names('pelanggan');
        Route::resource('/paket-langanan', PaketLanggananController::class)->names('paket-langanan')->except(['show']);
        Route::resource('/alamat', AreaAlamatController::class)->names('alamat')->except(['show']);

        Route::resource('pengumuman', PengumumanController::class)->only(['create', 'store']);
        Route::resource('logo', LogoController::class)->only(['create', 'store']);
        Route::resource('kasir', KasirController::class)->except('show');

        Route::prefix('/mikrotik')->name('mikrotik.')->group(function () {
            Route::get('/', [MikrotikController::class, 'index'])->name('index');
            Route::post('/update', [MikrotikController::class, 'update'])->name('update');
        });

        Route::prefix('/keuangan')->group(function () {
            Route::get('/', KeuanganController::class)->name('keuangan.index');
            Route::resource('pengeluaran', PengeluaranController::class)->names('pengeluaran')->only(['store', 'destroy']);
        });

        Route::name('profile.')->prefix('/profile')->group(function () {
            Route::post('/admin', [ProfileController::class, 'updateAdmin'])->name('update-admin');
        });

        Route::prefix('/tagihan')->name('tagihan.')->group(function () {
            Route::get('/', [TagihanController::class, 'index'])->name('index');
            Route::get('/{pelanggan}/riwayat', [TagihanController::class, 'riwayat'])->name('riwayat');
            Route::post('/{tagihan}/bayar', [TagihanController::class, 'bayar'])->name('bayar');
            Route::post('/{tagihan}/batal', [TagihanController::class, 'batal'])->name('batal');

            Route::get('/{tagihan}', [TagihanController::class, 'show'])->name('show');
            Route::name('subtagihan.')->group(function () {
                Route::post('/{tagihan}/add', [SubTagihanController::class, 'store'])->name('store');
                Route::delete('/{tagihan}/{subTagihan}/remove', [SubTagihanController::class, 'destroy'])->name('destroy');
            });
        });

        Route::prefix('/verifikasi-pembayaran')->name('verifikasi-pembayaran.')->group(function () {
            Route::get('/', [VerifikasiPembayaranKoordinatorController::class, 'index'])->name('index');
            Route::get('/{kasir}', [VerifikasiPembayaranKoordinatorController::class, 'show'])->name('show');
            Route::post('/{kasir}/{pembayaran}', [VerifikasiPembayaranKoordinatorController::class, 'store'])->name('store');
            Route::delete('/{kasir}/{pembayaran}', [VerifikasiPembayaranKoordinatorController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('/status-koneksi-server/update')->name('status-koneksi.')->group(function () {
            Route::get('/', [StatusKoneksiServerController::class, 'index'])->name('index');
            Route::post('/', [StatusKoneksiServerController::class, 'store'])->name('store');
        });
    });

    Route::name('profile.')->prefix('/profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show'])->name('show');
        Route::post('/logout', LogoutController::class)->name('logout');
    });
});
