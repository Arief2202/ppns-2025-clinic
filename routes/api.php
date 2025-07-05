<?php

use App\Http\Controllers\DataKesehatanMentalController;
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
use App\Http\Controllers\ObatBMHPController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PemeriksaanKesehatanBerkalaController;
use App\Http\Controllers\PemeriksaanKesehatanKhususController;
use App\Http\Controllers\PemeriksaanKesehatanSebelumBerkerjaController;
use App\Http\Controllers\PemusnahanObatController;
use App\Http\Controllers\PengadaanPenerimaanObatController;
use App\Http\Controllers\ProgramPromotifKesehatanMentalController;
use App\Http\Controllers\RegistrasiKunjunganPsikologController;
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


Route::get('/pasien/get', [PasienController::class, 'getById']);
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

Route::get('/manajemen-farmasi/daftar-obat-bmhp/get', [ObatBMHPController::class, 'getById']);
Route::get('/manajemen-farmasi/pengadaan/get', [PengadaanPenerimaanObatController::class, 'getById']);
Route::get('/manajemen-farmasi/penerimaan/get', [PengadaanPenerimaanObatController::class, 'getById']);
Route::get('/manajemen-farmasi/pemusnahan/get', [PemusnahanObatController::class, 'getById']);

Route::get('/kesehatan-mental/registrasi-kunjungan-psikolog/get', [RegistrasiKunjunganPsikologController::class, 'getById']);
Route::get('/kesehatan-mental/program-promotif-kesehatan-mental/get', [ProgramPromotifKesehatanMentalController::class, 'getById']);
Route::get('/kesehatan-mental/data-kesehatan-mental/get', [DataKesehatanMentalController::class, 'getById']);
