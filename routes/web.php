<?php

use App\Http\Controllers\UnitController;
use App\Http\Middleware\UserAkses;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ValidatorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SesiController;
use App\Http\Controllers\ValidationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\redirect;

// Route::get('/', function () {
//     return view('pages.index');
// });

// akses bagi pengguna yang belum melakukan login
Route::middleware(['guest'])->group(function(){
    Route::get('/', [SesiController::class, 'index'])->name('login');
    Route::post('/', [SesiController::class, 'login']);
});

// // mencegah agar tidak masuk ke /home
Route::get('/home', function(){
    return redirect('/logout');
});

Route::middleware(['auth'])->group(function(){

    // route untuk admin
    Route::get('/roleadmin/index', [AdminController::class, 'index'])->middleware(UserAkses::class . ':admin')->name('admin.index');
    Route::get('/roleadmin/filter-rekap', [AdminController::class, 'filterRekap'])->middleware(UserAkses::class . ':admin')->name('admin.filter_table');
    Route::get('/roleadmin/table', [AdminController::class, 'table'])->middleware(UserAkses::class . ':admin')->name('admin.table');
    Route::get('/roleadmin/create', [AdminController::class, 'create'])->middleware(UserAkses::class . ':admin')->name('admin.create');
    Route::post('/roleadmin/store', [AdminController::class, 'store'])->middleware(UserAkses::class . ':admin')->name('admin.store');
    Route::get('/roleadmin/{id}/edit', [AdminController::class, 'edit'])->middleware(UserAkses::class . ':admin')->name('admin.edit');
    Route::put('/roleadmin/{id}', [AdminController::class, 'update'])->middleware(UserAkses::class . ':admin')->name('admin.update');
    Route::delete('/roleadmin/{id}', [AdminController::class, 'destroy'])->middleware(UserAkses::class . ':admin')->name('admin.destroy');

    Route::get('/roleadmin/laporan', [AdminController::class, 'indexLaporan'])->middleware(UserAkses::class . ':admin')->name('admin.laporan.index');
    Route::get('/roleadmin/laporan/cetak', [AdminController::class, 'cetakLaporan'])->middleware(UserAkses::class . ':admin')->name('admin.laporan.cetak');


    // route untuk validator
    Route::get('/rolevalidator/index', [ValidatorController::class, 'index'])->middleware(UserAkses::class . ':validator')->name('validator.index');
    Route::get('/rolevalidator/filter-rekap', [ValidatorController::class, 'filterRekap'])->middleware(UserAkses::class . ':validator')->name('validator.filter_table');
    Route::get('/rolevalidator/table', [ValidatorController::class, 'table_Iki'])->middleware(UserAkses::class . ':validator')->name('validator.table_Iki');
    Route::get('/rolevalidator/tableIku', [ValidatorController::class, 'table_Iku'])->middleware(UserAkses::class . ':validator')->name('validator.table_Iku');

    // route penilaian IKI dan IKU
    // Route::get('/validasi', [PenilaianController::class, 'index'])->middleware(UserAkses::class . ':validator')->name('validasi.index');
    // Route::get('/validasi/{iki_id}', [PenilaianController::class, 'show'])->middleware(UserAkses::class . ':validator')->name('validasi.show');
    // Route::put('/validasi/{iki_id}', [PenilaianController::class, 'update'])->middleware(UserAkses::class . ':validator')->name('validasi.update');

    // menampilkan semua data karyawan yang sudah upload IKU dan IKI
    Route::get('/validation/index_iku', [ValidationController::class, 'index_iku'])->middleware(UserAkses::class . ':validator')->name('validation.index_iku');
    Route::get('/validation/index_iki', [ValidationController::class, 'index_iki'])->middleware(UserAkses::class . ':validator')->name('validation.index_iki');

    Route::get('/validation/iku/{id}',[ValidationController::class, 'show_iku'])->middleware(UserAkses::class . ':validator')->name('validation.show_iku');
    Route::get('/validation/iki/{id}',[ValidationController::class, 'show_iki'])->middleware(UserAkses::class . ':validator')->name('validation.show_iki');

    // preview foto hasil upload karyawan
    Route::get('/validation/iku/preview/{upload_iku_id}', [ValidationController::class, 'preview_iku'])->middleware(UserAkses::class . ':validator')->name('validation.preview_iku');
    Route::get('/validation/iki/preview/{upload_id}', [ValidationController::class, 'preview_iki'])->middleware(UserAkses::class . ':validator')->name('validation.preview_iki');

    // menyimpan dan menghapus data penilaian
    Route::post('/validation/store_penilaian_iku', [ValidationController::class, 'storePenilaian_iku'])->middleware(UserAkses::class . ':validator')->name('validation.store_penilaian_iku');
    Route::delete('/validation/delete_penilaian_iku/{id}', [ValidationController::class, 'deletePenilaian_iku'])->middleware(UserAkses::class . ':validator')->name('validation.delete_penilaian_iku');
    Route::post('/validation/store_penilaian_iki', [ValidationController::class, 'storePenilaian_iki'])->middleware(UserAkses::class . ':validator')->name('validation.store_penilaian_iki');
    Route::delete('/validation/delete_penilaian_iki/{id}', [ValidationController::class, 'deletePenilaian_iki'])->middleware(UserAkses::class . ':validator')->name('validation.delete_penilaian_iki');

    // route validator CRUD IKU
    Route::get('/rolevalidator/createIku', [ValidatorController::class, 'create_Iku'])->middleware(UserAkses::class . ':validator')->name('validator.create_Iku');
    Route::post('/rolevalidator/storeIku', [ValidatorController::class, 'store_Iku'])->middleware(UserAkses::class . ':validator')->name('validator.store_Iku');
    Route::get('/rolevalidator/{Iku_id}/editIku', [ValidatorController::class, 'edit_Iku'])->middleware(UserAkses::class . ':validator')->name('validator.edit_Iku');
    Route::put('/rolevalidator/iku/{Iku_id}', [ValidatorController::class, 'update_Iku'])->middleware(UserAkses::class . ':validator')->name('validator.update_Iku');
    Route::delete('/rolevalidator/iku/{Iku_id}', [ValidatorController::class, 'destroy_Iku'])->middleware(UserAkses::class . ':validator')->name('validator.destroy_Iku');

    // route validator CRUD IKI
    Route::get('/rolevalidator/createIki', [ValidatorController::class, 'create_Iki'])->middleware(UserAkses::class . ':validator')->name('validator.create_Iki');
    Route::post('/rolevalidator/storeIki', [ValidatorController::class, 'store_Iki'])->middleware(UserAkses::class . ':validator')->name('validator.store_Iki');
    Route::get('/rolevalidator/{indikator_id}/editIki', [ValidatorController::class, 'edit_Iki'])->middleware(UserAkses::class . ':validator')->name('validator.edit_Iki');
    Route::put('/rolevalidator/iki/{indikator_id}', [ValidatorController::class, 'update_Iki'])->middleware(UserAkses::class . ':validator')->name('validator.update_Iki');
    Route::delete('/rolevalidator/iki/{indikator_id}', [ValidatorController::class, 'destroy_Iki'])->middleware(UserAkses::class . ':validator')->name('validator.destroy_Iki');

    // route untuk karyawan
    Route::get('/rolekaryawan/index', [KaryawanController::class, 'index'])->middleware(UserAkses::class . ':karyawan')->name('karyawan.index');
    Route::get('/rolekaryawan/table', [KaryawanController::class, 'table'])->middleware(UserAkses::class . ':karyawan')->name('karyawan.table');

    // route Karyawan CRD file IKU
    Route::post('/karyawan/uploadiku', [KaryawanController::class, 'store_Iku'])->name('karyawan.store_Iku');
    Route::get('/karyawan/uploadiku', [KaryawanController::class, 'upload_Iku'])->name('karyawan.upload_Iku');
    Route::get('/karyawan/previewiku/{upload_iku_id}', [KaryawanController::class, 'preview_Iku'])->name('karyawan.preview_Iku');
    Route::delete('/karyawan/deleteiku/{upload_iku_id}', [KaryawanController::class, 'destroy_Iku'])->name('karyawan.destroy_Iku');

    // route Karyawan CRD file IKI
    Route::post('/karyawan/uploadiki', [KaryawanController::class, 'store_Iki'])->name('karyawan.store_Iki');
    Route::get('/karyawan/uploadiki', [KaryawanController::class, 'upload_Iki'])->name('karyawan.upload_Iki');
    Route::get('/karyawan/previewiki/{upload_id}', [KaryawanController::class, 'preview_Iki'])->name('karyawan.preview_Iki');
    Route::delete('/karyawan/deleteiki/{upload_id}', [KaryawanController::class, 'destroy_Iki'])->name('karyawan.destroy_Iki');

    // route logout
    Route::get('/logout',[SesiController::class, 'logout']);
});



Route::resource('unit', UnitController::class);