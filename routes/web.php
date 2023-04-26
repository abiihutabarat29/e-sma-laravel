<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KabupatenController;
use App\Http\Controllers\Admin\SekolahController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\MapelController;
use App\Http\Controllers\Admin\SaranaController;
use App\Http\Controllers\Admin\InventarisController;

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
    Route::get('login', 'index')->name('login')->middleware('guest');
    Route::post('login', 'login')->middleware('guest');
    Route::get('logout', 'logout')->name('logout');
});
Route::group(['middleware' => ['auth:user,admincbd']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', [UserController::class, 'profil'])->name('profil.index');
    Route::put('profile/{user}/update', [UserController::class, 'updateprofil'])->name('profil.update');
    Route::put('profile/{user}/update-password', [UserController::class, 'updatepassword'])->name('profil.update.password');
    Route::put('profile/{user}/update-foto', [UserController::class, 'updatefoto'])->name('profil.update.foto');
    Route::group(['middleware' => ['checkUser:1']], function () {
        // Route cabdis
        // Kabupaten
        Route::resource('kabupaten', KabupatenController::class);
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
    });
    Route::group(['middleware' => ['checkUser:2']], function () {
        // route user sekolah
    });
});
