<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FasilitasPrasaranaController;
use App\Http\Controllers\HealthRiskAssesmentController;
use App\Http\Controllers\InformasiTataRuangKlinikController;
use App\Http\Controllers\InventarisPeralatanController;
use App\Http\Controllers\IzinPendirianDanOperasionalKlinikController;
use App\Http\Controllers\LaporanAnalisisKecelakaanKerjaController;
use App\Http\Controllers\LaporanKecelakaanKerjaController;
use App\Http\Controllers\LaporanPelayananDanPemeriksaanKesehatanController;
use App\Http\Controllers\PemeriksaanKesehatanBerkalaController;
use App\Http\Controllers\PemeriksaanKesehatanKhususController;
use App\Http\Controllers\PemeriksaanKesehatanSebelumBerkerjaController;
use App\Http\Controllers\RencanaPemeriksaanKesehatanController;
use App\Http\Controllers\SKPTenagaKesehatanController;
use App\Http\Controllers\StandardOperasionalProsedurKlinikController;
use App\Models\PedomanPemeriksaanKesehatan;

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


Route::get('/user/get', [UserController::class, 'getById']);

Route::get('/sarana-prasarana/informasi-tata-ruang-klinik', [InformasiTataRuangKlinikController::class, 'getById']);
Route::get('/sarana-prasarana/fasilitas-prasarana', [FasilitasPrasaranaController::class, 'getById']);
Route::get('/sarana-prasarana/inventaris-peralatan', [InventarisPeralatanController::class, 'getById']);
Route::get('/sarana-prasarana/izin-pendirian-dan-operasional-klinik', [IzinPendirianDanOperasionalKlinikController::class, 'getById']);
Route::get('/sarana-prasarana/standard-operasional-prosedur-klinik', [StandardOperasionalProsedurKlinikController::class, 'getById']);

Route::get('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-sebelum-bekerja/get', [PemeriksaanKesehatanSebelumBerkerjaController::class, 'getById']);
Route::get('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-berkala/get', [PemeriksaanKesehatanBerkalaController::class, 'getById']);
Route::get('/smk3/pemeriksaan-kesehatan-pekerja/pemeriksaan-kesehatan-khusus/get', [PemeriksaanKesehatanKhususController::class, 'getById']);
Route::get('/smk3/pemeriksaan-kesehatan-pekerja/rencana-pemeriksaan-kesehatan/get', [RencanaPemeriksaanKesehatanController::class, 'getById']);
Route::get('/smk3/pemeriksaan-kesehatan-pekerja/pedoman-pemeriksaan-kesehatan/get', [PedomanPemeriksaanKesehatan::class, 'getById']);
Route::get('/smk3/health-risk-assesment/get', [HealthRiskAssesmentController::class, 'getById']);
Route::get('/smk3/laporan-pelayanan-dan-pemeriksaan-kesehatan/get', [LaporanPelayananDanPemeriksaanKesehatanController::class, 'getById']);
Route::get('/smk3/skp-tenaga-kesehatan/get', [SKPTenagaKesehatanController::class, 'getById']);

Route::get('/pelaporan-kecelakaan/laporan-kecelakaan-kerja', [LaporanKecelakaanKerjaController::class, 'getById']);
Route::get('/pelaporan-kecelakaan/laporan-analisis-kecelakaan-kerja', [LaporanAnalisisKecelakaanKerjaController::class, 'getById']);
