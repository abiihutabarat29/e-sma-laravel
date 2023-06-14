<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KabupatenController;
use App\Http\Controllers\Admin\KecamatanController;
use App\Http\Controllers\Admin\DesaController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\SaranaController;
use App\Http\Controllers\Admin\InventarisController;
use App\Http\Controllers\Admin\GolonganController;
use App\Http\Controllers\Admin\JurusanController;
use App\Http\Controllers\Admin\GuruController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\Admin\ProfileSekolahController;
use App\Http\Controllers\Admin\BangunanController;
use App\Http\Controllers\Admin\RombelController;
use App\Http\Controllers\Admin\DaklController;
use App\Http\Controllers\Admin\InventarisSekolahController;
use App\Http\Controllers\Admin\SarprasController;
use App\Http\Controllers\Admin\MutasiController;

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

Route::get('/', function () {
    return view('welcome');
});
Route::controller(AuthController::class)->group(function () {
    // Login
    Route::get('login', 'index')->name('login')->middleware('guest');
    Route::post('login', 'login')->middleware('guest');
    Route::get('logout', 'logout')->name('logout');
});
Route::group(['middleware' => ['auth:user,admincbd']], function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Profil
    Route::get('profile', [UserController::class, 'profil'])->name('profil.index');
    Route::put('profile/{user}/update', [UserController::class, 'updateprofil'])->name('profil.update');
    Route::put('profile/{user}/update-password', [UserController::class, 'updatepassword'])->name('profil.update.password');
    Route::put('profile/{user}/update-foto', [UserController::class, 'updatefoto'])->name('profil.update.foto');
    // Download Manual Book
    Route::get('download', [ManualBookController::class, 'download'])->name('download');
    //Get Data JSON
    Route::post('kabupaten/get-kabupaten', [KabupatenController::class, 'getKabupaten']);
    Route::post('kecamatan/get-kecamatan', [KecamatanController::class, 'getKecamatan']);
    Route::post('desa/get-desa', [DesaController::class, 'getDesa']);
    Route::post('mata-pelajaran/get-mapel', [MapelController::class, 'getMapel']);
    Route::post('sarana/get-sarana', [SaranaController::class, 'getSarana']);
    Route::post('inventaris/get-inventaris', [InventarisController::class, 'getInventaris']);
    // Route cabdis
    Route::group(['middleware' => ['checkUser:1']], function () {
        // Kabupaten
        Route::resource('kabupaten', KabupatenController::class);
        // Kecamatan
        Route::resource('kecamatan', KecamatanController::class);
        // Desa/Kelurahan
        Route::resource('desa', DesaController::class);
        // Sekolah
        Route::get('sekolah', [SekolahController::class, 'index'])->name('sekolah.index');
        Route::post('sekolah', [SekolahController::class, 'store'])->name('sekolah.store');
        Route::get('sekolah/{id}/edit', [SekolahController::class, 'edit'])->name('sekolah.edit');
        Route::delete('sekolah/{id}/destroy', [SekolahController::class, 'destroy'])->name('sekolah.destroy');
        // Users
        Route::get('users-sekolah', [UserController::class, 'index'])->name('user.index');
        Route::post('users-sekolah', [UserController::class, 'store'])->name('user.store');
        Route::get('users-sekolah/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::delete('users-sekolah/{user}/destroy', [UserController::class, 'destroy'])->name('user.destroy');
        // Mata Pelajaran
        Route::resource('mata-pelajaran', MapelController::class);
        // Sarana
        Route::resource('sarana', SaranaController::class);
        // Inventaris
        Route::resource('inventaris', InventarisController::class);
        // Golongan
        Route::resource('golongan', GolonganController::class);
        // Jurusan
        Route::resource('jurusan', JurusanController::class);
    });
    // Route user sekolah
    Route::group(['middleware' => ['checkUser:2']], function () {
        // Guru
        Route::get('guru', [GuruController::class, 'index'])->name('guru.index');
        Route::get('guru/create', [GuruController::class, 'create'])->name('guru.create');
        Route::post('guru', [GuruController::class, 'store'])->name('guru.store');
        Route::get('guru/{id}/edit', [GuruController::class, 'edit'])->name('guru.edit');
        Route::put('guru/{id}/update', [GuruController::class, 'update'])->name('guru.update');
        Route::delete('guru/{guru}/destroy', [GuruController::class, 'destroy'])->name('guru.destroy');
        // Pegawai
        Route::get('pegawai', [PegawaiController::class, 'index'])->name('pegawai.index');
        Route::get('pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
        Route::post('pegawai', [PegawaiController::class, 'store'])->name('pegawai.store');
        Route::get('pegawai/{id}/edit', [PegawaiController::class, 'edit'])->name('pegawai.edit');
        Route::put('pegawai/{id}/update', [PegawaiController::class, 'update'])->name('pegawai.update');
        Route::delete('pegawai/{pegawai}/destroy', [PegawaiController::class, 'destroy'])->name('pegawai.destroy');
        // Siswa
        Route::get('siswa', [SiswaController::class, 'index'])->name('siswa.index');
        Route::get('siswa/create', [SiswaController::class, 'create'])->name('siswa.create');
        Route::post('siswa', [SiswaController::class, 'store'])->name('siswa.store');
        Route::get('siswa/{id}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
        Route::put('siswa/{id}/update', [SiswaController::class, 'update'])->name('siswa.update');
        Route::delete('siswa/{siswa}/destroy', [SiswaController::class, 'destroy'])->name('siswa.destroy');
        //Profil Sekolah
        Route::get('profile-sekolah', [ProfileSekolahController::class, 'index'])->name('profile-sekolah.index');
        Route::get('profile-sekolah/create', [ProfileSekolahController::class, 'create'])->name('profile-sekolah.create');
        Route::post('profile-sekolah', [ProfileSekolahController::class, 'store'])->name('profile-sekolah.store');
        Route::get('profile-sekolah/{id}/edit', [ProfileSekolahController::class, 'edit'])->name('profile-sekolah.edit');
        Route::put('profile-sekolah/{id}/update', [ProfileSekolahController::class, 'update'])->name('profile-sekolah.update');
        //Bangunan
        Route::resource('wilayah-sekolah', BangunanController::class);
        //Kelas/Rombel
        Route::resource('rombel-sekolah', RombelController::class);
        Route::post('rombel-sekolah/get-rombel', [RombelController::class, 'getRombel']);
        //DAKL
        Route::resource('dakl', DaklController::class);
        //Sarpras
        Route::resource('sarpras', SarprasController::class);
        //Inventaris
        Route::resource('inventaris-sekolah', InventarisSekolahController::class);
        // Mutasi Masuk
        Route::get('mutasi-masuk', [MutasiController::class, 'index'])->name('mutasi-masuk.index');
        Route::get('mutasi-masuk/create', [MutasiController::class, 'create'])->name('mutasi-masuk.create');
        Route::post('mutasi-masuk', [MutasiController::class, 'store'])->name('mutasi-masuk.store');
        Route::get('mutasi-masuk/{id}/edit', [MutasiController::class, 'edit'])->name('mutasi-masuk.edit');
        Route::put('mutasi-masuk/{id}/update', [MutasiController::class, 'update'])->name('mutasi-masuk.update');
        Route::delete('mutasi-masuk/{mutasi}/destroy', [MutasiController::class, 'destroy'])->name('mutasi-masuk.destroy');
        // Mutasi Keluar
        Route::get('mutasi-keluar', [MutasiController::class, 'indexk'])->name('mutasi-keluar.index');
        Route::get('mutasi-keluar/create', [MutasiController::class, 'createk'])->name('mutasi-keluar.create');
        Route::post('mutasi-keluar', [MutasiController::class, 'storek'])->name('mutasi-keluar.store');
        Route::get('mutasi-keluar/{id}/edit', [MutasiController::class, 'editk'])->name('mutasi-keluar.edit');
        Route::put('mutasi-keluar/{id}/update', [MutasiController::class, 'updatek'])->name('mutasi-keluar.update');
        Route::delete('mutasi-keluar/{siswa}/destroy', [MutasiController::class, 'destroyk'])->name('mutasi-keluar.destroy');
    });
});
