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

    // route untuk ADMIN =========================================================================================================================================================================

        // USERS
        Route::get('/roleadmin/users/index', [AdminController::class, 'userIndex'])->middleware(UserAkses::class . ':admin')->name('admin.user_index');
        Route::get('/roleadmin/users/show', [AdminController::class, 'userShow'])->middleware(UserAkses::class . ':admin')->name('admin.user_show');
        Route::get('/roleadmin/users/create', [AdminController::class, 'userCreate'])->middleware(UserAkses::class . ':admin')->name('admin.user_create');
        Route::post('/roleadmin/users/store', [AdminController::class, 'userStore'])->middleware(UserAkses::class . ':admin')->name('admin.user_store');
        Route::get('/roleadmin/users/edit/{id}', [AdminController::class, 'userEdit'])->middleware(UserAkses::class . ':admin')->name('admin.user_edit');
        Route::put('/roleadmin/users/update/{id}', [AdminController::class, 'userUpdate'])->middleware(UserAkses::class . ':admin')->name('admin.user_update');
        Route::delete('/roleadmin/users/delete/{id}', [AdminController::class, 'userDelete'])->middleware(UserAkses::class . ':admin')->name('admin.user_delete');

        // UNITS
        Route::get('/roleadmin/units/index', [AdminController::class, 'unitIndex'])->middleware(UserAkses::class . ':admin')->name('admin.unit_index');
        Route::get('/roleadmin/units/show', [AdminController::class, 'unitShow'])->middleware(UserAkses::class . ':admin')->name('admin.unit_show');
        Route::get('/roleadmin/units/create', [AdminController::class, 'unitCreate'])->middleware(UserAkses::class . ':admin')->name('admin.unit_create');
        Route::post('/roleadmin/units/store', [AdminController::class, 'unitStore'])->middleware(UserAkses::class . ':admin')->name('admin.unit_store');
        Route::get('/roleadmin/units/edit/{id}', [AdminController::class, 'unitEdit'])->middleware(UserAkses::class . ':admin')->name('admin.unit_edit');
        Route::put('/roleadmin/units/update{id}', [AdminController::class, 'unitUpdate'])->middleware(UserAkses::class . ':admin')->name('admin.unit_update');
        Route::delete('/roleadmin/units/delete/{id}', [AdminController::class, 'unitDelete'])->middleware(UserAkses::class . ':admin')->name('admin.unit_delete');

        // JABATANS
        Route::get('/roleadmin/jabatans/index', [AdminController::class, 'jabatanIndex'])->middleware(UserAkses::class . ':admin')->name('admin.jabatan_index');
        Route::get('/roleadmin/jabatans/show', [AdminController::class, 'jabatanShow'])->middleware(UserAkses::class . ':admin')->name('admin.jabatan_show');
        Route::get('/roleadmin/jabatans/create', [AdminController::class, 'jabatanCreate'])->middleware(UserAkses::class . ':admin')->name('admin.jabatan_create');
        Route::post('/roleadmin/jabatans/store', [AdminController::class, 'jabatanStore'])->middleware(UserAkses::class . ':admin')->name('admin.jabatan_store');
        Route::get('/roleadmin/jabatans/edit/{id}', [AdminController::class, 'jabatanEdit'])->middleware(UserAkses::class . ':admin')->name('admin.jabatan_edit');
        Route::put('/roleadmin/jabatans/update{id}', [AdminController::class, 'jabatanUpdate'])->middleware(UserAkses::class . ':admin')->name('admin.jabatan_update');
        Route::delete('/roleadmin/jabatans/delete/{id}', [AdminController::class, 'jabatanDelete'])->middleware(UserAkses::class . ':admin')->name('admin.jabatan_delete');
     
        // OTHERS
        Route::get('/roleadmin/dashboard', [AdminController::class, 'dashboard'])->middleware(UserAkses::class . ':admin')->name('admin.dashboard');
        Route::get('/roleadmin/filter-rekap', [AdminController::class, 'filterRekap'])->middleware(UserAkses::class . ':admin')->name('admin.filter_table');
        Route::get('/roleadmin/laporan', [AdminController::class, 'indexLaporan'])->middleware(UserAkses::class . ':admin')->name('admin.laporan.index');
        Route::get('/roleadmin/laporan/cetak', [AdminController::class, 'cetakLaporan'])->middleware(UserAkses::class . ':admin')->name('admin.laporan.cetak');

    // route untuk ADMIN =========================================================================================================================================================================
    // ===========================================================================================================================================================================================
    // route untuk VALIDATOR =====================================================================================================================================================================

        // IKI
        Route::get('/rolevalidator/ikis/index', [ValidatorController::class, 'ikiIndex'])->middleware(UserAkses::class . ':validator')->name('validator.iki_index');
        Route::get('/rolevalidator/ikis/show', [ValidatorController::class, 'ikiShow'])->middleware(UserAkses::class . ':validator')->name('validator.iki_show');
        Route::get('/rolevalidator/ikis/create', [ValidatorController::class, 'ikiCreate'])->middleware(UserAkses::class . ':validator')->name('validator.iki_create');
        Route::post('/rolevalidator/ikis/store', [ValidatorController::class, 'ikiStore'])->middleware(UserAkses::class . ':validator')->name('validator.iki_store');
        Route::get('/rolevalidator/ikis/edit/{id}', [ValidatorController::class, 'ikiEdit'])->middleware(UserAkses::class . ':validator')->name('validator.iki_edit');
        Route::put('/rolevalidator/ikis/update/{id}', [ValidatorController::class, 'ikiUpdate'])->middleware(UserAkses::class . ':validator')->name('validator.iki_update');
        Route::delete('/rolevalidator/ikis/delete/{id}', [ValidatorController::class, 'ikiDelete'])->middleware(UserAkses::class . ':validator')->name('validator.iki_delete');

        // IKU
        Route::get('/rolevalidator/ikus/index', [ValidatorController::class, 'ikuIndex'])->middleware(UserAkses::class . ':validator')->name('validator.iku_index');
        Route::get('/rolevalidator/ikus/show', [ValidatorController::class, 'ikuShow'])->middleware(UserAkses::class . ':validator')->name('validator.iku_show');
        Route::get('/rolevalidator/ikus/create', [ValidatorController::class, 'ikuCreate'])->middleware(UserAkses::class . ':validator')->name('validator.iku_create');
        Route::post('/rolevalidator/ikus/store', [ValidatorController::class, 'ikuStore'])->middleware(UserAkses::class . ':validator')->name('validator.iku_store');
        Route::get('/rolevalidator/ikus/edit/{id}', [ValidatorController::class, 'ikuEdit'])->middleware(UserAkses::class . ':validator')->name('validator.iku_edit');
        Route::put('/rolevalidator/ikus/update/{id}', [ValidatorController::class, 'ikuUpdate'])->middleware(UserAkses::class . ':validator')->name('validator.iku_update');
        Route::delete('/rolevalidator/ikus/delete/{id}', [ValidatorController::class, 'ikuDelete'])->middleware(UserAkses::class . ':validator')->name('validator.iku_delete');

        // OTHERS
        Route::get('/rolevalidator/dashboard', [ValidatorController::class, 'dashboard'])->middleware(UserAkses::class . ':validator')->name('validator.dashboard');
        Route::get('/rolevalidator/laporan', [ValidatorController::class, 'laporan'])->middleware(UserAkses::class . ':validator')->name('validator.laporan');
        Route::get('/rolevalidator/filter-rekap', [ValidatorController::class, 'filterRekap'])->middleware(UserAkses::class . ':validator')->name('validator.filter_table');

    // route untuk VALIDATOR =====================================================================================================================================================================
    // ===========================================================================================================================================================================================
    // route untuk KARYAWAN ======================================================================================================================================================================

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

        Route::get('/rolekaryawan/dashboard', [KaryawanController::class, 'dashboard'])->middleware(UserAkses::class . ':karyawan')->name('karyawan.dashboard');
        Route::get('/rolekaryawan/laporan', [KaryawanController::class, 'laporan'])->middleware(UserAkses::class . ':karyawan')->name('karyawan.laporan');
        Route::get('/rolekaryawan/setting', [KaryawanController::class, 'setting'])->middleware(UserAkses::class . ':karyawan')->name('karyawan.setting');

    // route untuk KARYAWAN ======================================================================================================================================================================
    // ===========================================================================================================================================================================================
    // route untuk VALIDATE ======================================================================================================================================================================

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

    // route untuk VALIDATE ======================================================================================================================================================================
    // ===========================================================================================================================================================================================
    // route untuk fitur lainnya =================================================================================================================================================================

        // route untuk export data ke excel
        Route::get('/rolevalidator/excel', [ValidatorController::class, 'excel'])->middleware(UserAkses::class . ':validator')->name('validator.excel');

        // route logout
        Route::get('/logout',[SesiController::class, 'logout']);
    
    // route untuk fitur lainnya =================================================================================================================================================================

});

Route::resource('unit', UnitController::class);