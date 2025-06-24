<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FasilitasPrasaranaController;
use App\Http\Controllers\HealthRiskAssesmentController;
use App\Http\Controllers\InventarisPeralatanController;
use App\Http\Controllers\LaporanKecelakaanKerjaController;
use App\Http\Controllers\InformasiTataRuangKlinikController;
use App\Http\Controllers\PemeriksaanKesehatanKhususController;
use App\Http\Controllers\PedomanPemeriksaanKesehatanController;
use App\Http\Controllers\PemeriksaanKesehatanBerkalaController;
use App\Http\Controllers\RencanaPemeriksaanKesehatanController;
use App\Http\Controllers\LaporanAnalisisKecelakaanKerjaController;
use App\Http\Controllers\IzinPendirianDanOperasionalKlinikController;
use App\Http\Controllers\StandardOperasionalProsedurKlinikController;
use App\Http\Controllers\PemeriksaanKesehatanSebelumBerkerjaController;
use App\Http\Controllers\LaporanPelayananDanPemeriksaanKesehatanController;
use App\Http\Controllers\SKPTenagaKesehatanController;

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
Route::get('/version', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/', function () {
    if(!Auth::user()) return view('login.read');
    return redirect('/dashboard');
});
Route::get('/login', function () {
    if(!Auth::user()) return view('login.read');
    return redirect('/dashboard');
})->name('login');
Route::get('/test', function () {
    return view('test');
});

Route::middleware('auth')->group(function () {

    Route::controller(UserController::class)->group(function () {
        Route::get('/users', 'index');
        Route::post('/users', 'create')->name('user_create');
        Route::post('/users/edit', 'edit')->name('user_edit');
        Route::post('/users/delete', 'delete')->name('user_delete');
    });

    Route::controller(InformasiTataRuangKlinikController::class)->group(function () {
        Route::get('/sarana-prasarana/informasi-tata-ruang-klinik', 'index');
        Route::post('/sarana-prasarana/informasi-tata-ruang-klinik', 'create');
        Route::post('/sarana-prasarana/informasi-tata-ruang-klinik/edit', 'edit');
        Route::post('/sarana-prasarana/informasi-tata-ruang-klinik/validate', 'validate_image');
        Route::post('/sarana-prasarana/informasi-tata-ruang-klinik/delete', 'delete');
    });
    Route::controller(FasilitasPrasaranaController::class)->group(function () {
        Route::get('/sarana-prasarana/fasilitas-prasarana', 'index');
        Route::post('/sarana-prasarana/fasilitas-prasarana', 'create');
        Route::post('/sarana-prasarana/fasilitas-prasarana/edit', 'edit');
        Route::post('/sarana-prasarana/fasilitas-prasarana/delete', 'delete');
        Route::post('/sarana-prasarana/fasilitas-prasarana/validate', 'validate_data');
    });
    Route::controller(InventarisPeralatanController::class)->group(function () {
        Route::get('/sarana-prasarana/inventaris-peralatan', 'index');
        Route::post('/sarana-prasarana/inventaris-peralatan', 'create');
        Route::post('/sarana-prasarana/inventaris-peralatan/edit', 'edit');
        Route::post('/sarana-prasarana/inventaris-peralatan/delete', 'delete');
        Route::post('/sarana-prasarana/inventaris-peralatan/validate', 'validate_data');
    });
    Route::controller(IzinPendirianDanOperasionalKlinikController::class)->group(function () {
        Route::get('/sarana-prasarana/izin-pendirian-dan-operasional-klinik', 'index');
        Route::post('/sarana-prasarana/izin-pendirian-dan-operasional-klinik', 'create');
        Route::post('/sarana-prasarana/izin-pendirian-dan-operasional-klinik/edit', 'edit');
        Route::post('/sarana-prasarana/izin-pendirian-dan-operasional-klinik/delete', 'delete');
        Route::post('/sarana-prasarana/izin-pendirian-dan-operasional-klinik/validate', 'validate_data');
    });
    Route::controller(StandardOperasionalProsedurKlinikController::class)->group(function () {
        Route::get('/sarana-prasarana/standard-operasional-prosedur-klinik', 'index');
        Route::post('/sarana-prasarana/standard-operasional-prosedur-klinik', 'create');
        Route::post('/sarana-prasarana/standard-operasional-prosedur-klinik/edit', 'edit');
        Route::post('/sarana-prasarana/standard-operasional-prosedur-klinik/delete', 'delete');
    });

    Route::controller(PemeriksaanKesehatanSebelumBerkerjaController::class)->group(function () {
        Route::get('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-sebelum-bekerja', 'index');
        Route::post('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-sebelum-bekerja', 'create');
        Route::post('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-sebelum-bekerja/edit', 'edit');
        Route::post('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-sebelum-bekerja/delete', 'delete');
    });
    Route::controller(PemeriksaanKesehatanBerkalaController::class)->group(function () {
        Route::get('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-berkala', 'index');
        Route::post('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-berkala', 'create');
        Route::post('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-berkala/edit', 'edit');
        Route::post('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-berkala/delete', 'delete');
    });
    Route::controller(PemeriksaanKesehatanKhususController::class)->group(function () {
        Route::get('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-khusus', 'index');
        Route::post('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-khusus', 'create');
        Route::post('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-khusus/edit', 'edit');
        Route::post('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-khusus/delete', 'delete');
    });
    Route::controller(RencanaPemeriksaanKesehatanController::class)->group(function () {
        Route::get('/smk3/pemeriksaan-kesehatan-pekerja/rencana-pemeriksaan-kesehatan', 'index');
        Route::post('/smk3/pemeriksaan-kesehatan-pekerja/rencana-pemeriksaan-kesehatan', 'create');
        Route::post('/smk3/pemeriksaan-kesehatan-pekerja/rencana-pemeriksaan-kesehatan/edit', 'edit');
        Route::post('/smk3/pemeriksaan-kesehatan-pekerja/rencana-pemeriksaan-kesehatan/delete', 'delete');
        Route::post('/smk3/pemeriksaan-kesehatan-pekerja/rencana-pemeriksaan-kesehatan/validate', 'validate_data');
    });
    Route::controller(PedomanPemeriksaanKesehatanController::class)->group(function () {
        Route::get('/smk3/pemeriksaan-kesehatan-pekerja/pedoman-pemeriksaan-kesehatan', 'index');
        Route::post('/smk3/pemeriksaan-kesehatan-pekerja/pedoman-pemeriksaan-kesehatan', 'create');
        Route::post('/smk3/pemeriksaan-kesehatan-pekerja/pedoman-pemeriksaan-kesehatan/edit', 'edit');
        Route::post('/smk3/pemeriksaan-kesehatan-pekerja/pedoman-pemeriksaan-kesehatan/delete', 'delete');
    });
    Route::controller(HealthRiskAssesmentController::class)->group(function () {
        Route::get('/smk3/health-risk-assesment', 'index');
        Route::post('/smk3/health-risk-assesment', 'create');
        Route::post('/smk3/health-risk-assesment/edit', 'edit');
        Route::post('/smk3/health-risk-assesment/delete', 'delete');
        Route::post('/smk3/health-risk-assesment/validate', 'validate_data');
    });
    Route::controller(LaporanPelayananDanPemeriksaanKesehatanController::class)->group(function () {
        Route::get('/smk3/laporan-pelayanan-dan-pemeriksaan-kesehatan', 'index');
        Route::post('/smk3/laporan-pelayanan-dan-pemeriksaan-kesehatan', 'create');
        Route::post('/smk3/laporan-pelayanan-dan-pemeriksaan-kesehatan/edit', 'edit');
        Route::post('/smk3/laporan-pelayanan-dan-pemeriksaan-kesehatan/delete', 'delete');
        Route::post('/smk3/laporan-pelayanan-dan-pemeriksaan-kesehatan/validate', 'validate_data');
    });
    Route::controller(SKPTenagaKesehatanController::class)->group(function () {
        Route::get('/smk3/skp-tenaga-kesehatan', 'index');
        Route::post('/smk3/skp-tenaga-kesehatan', 'create');
        Route::post('/smk3/skp-tenaga-kesehatan/edit', 'edit');
        Route::post('/smk3/skp-tenaga-kesehatan/delete', 'delete');
    });
    Route::controller(LaporanKecelakaanKerjaController::class)->group(function () {
        Route::get('/pelaporan-kecelakaan/laporan-kecelakaan-kerja', 'index');
        Route::post('/pelaporan-kecelakaan/laporan-kecelakaan-kerja', 'create');
        Route::post('/pelaporan-kecelakaan/laporan-kecelakaan-kerja/edit', 'edit');
        Route::post('/pelaporan-kecelakaan/laporan-kecelakaan-kerja/delete', 'delete');
    });
    Route::controller(LaporanAnalisisKecelakaanKerjaController::class)->group(function () {
        Route::get('/pelaporan-kecelakaan/laporan-analisis-kecelakaan-kerja', 'index');
        Route::post('/pelaporan-kecelakaan/laporan-analisis-kecelakaan-kerja', 'create');
        Route::post('/pelaporan-kecelakaan/laporan-analisis-kecelakaan-kerja/edit', 'edit');
        Route::post('/pelaporan-kecelakaan/laporan-analisis-kecelakaan-kerja/delete', 'delete');
    });

    Route::post('/changeSideBarState', function(Request $request) {
        $user = User::where('id', Auth::user()->id)->first();
        $user->openSidebar = $request->sideBarState;
        $user->save();
    });
    Route::post('/changeDarkMode', function(Request $request) {
        $user = User::where('id', Auth::user()->id)->first();
        $user->darkMode = $request->darkMode;
        $user->save();
    });
});

Route::middleware('auth')->group(function () { //FOR MENU PAGE
    Route::get('/dashboard', function () {
        return view('menu', [
            "title" => "Dashboard",
            "menu" => [
                ['/sarana-prasarana', 'Sarana Prasarana'],
                // ['/manajemen-farmasi', 'Manajemen Farmasi'],
                // ['/kesehatan-mental', 'Kesehatan Mental'],
                ['/pelaporan-kecelakaan', 'Pelaporan Kecelakaan'],
                ['/smk3', 'SMK 3'],
                // ['/rekam-medis', 'Rekam Medis'],
            ]
        ]);
    })->name('dashboard');

    Route::get('/sarana-prasarana', function () {
        return view('menu', [
            "title" => "Sarana Prasarana",
            "menu" => [
                ['/sarana-prasarana/informasi-tata-ruang-klinik', 'Informasi Tata Ruang Klinik'],
                ['/sarana-prasarana/fasilitas-prasarana', 'Fasilitas Prasarana'],
                ['/sarana-prasarana/inventaris-peralatan', 'Inventaris Peralatan'],
                ['/sarana-prasarana/izin-pendirian-dan-operasional-klinik', 'Izin Pendirian Dan Operasional Klinik'],
                ['/sarana-prasarana/standard-operasional-prosedur-klinik', 'Standard Operasional Prosedur Klinik'],
            ]
        ]);
    })->name('sarana-prasarana');

    Route::get('/smk3', function () {
        return view('menu', [
            "title" => "SMK3",
            "menu" => [
                ['/smk3/pemeriksaan-kesehatan-pekerja', 'Pemeriksaan Kesehatan Pekerja'],
                ['/smk3/health-risk-assesment', 'Health Risk Assesment'],
                ['/smk3/laporan-pelayanan-dan-pemeriksaan-kesehatan', 'Laporan Pelayanan dan Pemeriksaan Kesehatan'],
            ]
        ]);
    })->name('smk3');
    Route::get('/smk3/pemeriksaan-kesehatan-pekerja', function () {
        return view('menu', [
            "title" => "SMK3 > Pemeriksaan Kesehatan Pekerja",
            "menu" => [
                ['/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-sebelum-bekerja', 'Pemeriksaan Kesehatan Sebelum Bekerja'],
                ['/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-berkala', 'Pemeriksaan Kesehatan Berkala'],
                ['/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-khusus', 'Pemeriksaan Kesehatan Khusus'],
                ['/smk3/pemeriksaan-kesehatan-pekerja/rencana-pemeriksaan-kesehatan', 'Rencana Pemeriksaan Kesehatan'],
                ['/smk3/pemeriksaan-kesehatan-pekerja/pedoman-pemeriksaan-kesehatan', 'Pedoman Pemeriksaan Kesehatan'],
            ]
        ]);
    })->name('pemeriksaan-kesehatan-pekerja');

    Route::get('/pelaporan-kecelakaan', function () {
        return view('menu', [
            "title" => "Pelaporan Kecelakaan",
            "menu" => [
                ['/pelaporan-kecelakaan/laporan-kecelakaan-kerja', 'Laporan Kecelakaan Kerja'],
                ['/pelaporan-kecelakaan/laporan-analisis-kecelakaan-kerja', 'Laporan Analisis Kecelakaan Kerja'],
            ]
        ]);
    })->name('pelaporan-kecelakaan');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
