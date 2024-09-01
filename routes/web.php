<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\PerhitunganVAMController;
use App\Http\Controllers\DistribusiController;
use App\Http\Controllers\PermintaanController;
use App\Http\Controllers\UserKecController;
use App\Http\Middleware\CustomMiddleware;
use App\Http\Middleware\CustomMiddlewareKec;
use App\Models\Permintaan;
use Illuminate\Support\Facades\Route;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
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



Route::get('/login-admin', [AuthController::class, 'index'])->middleware('Guest');
Route::post('/login-admin', [AuthController::class, 'authentication'])->middleware('Guest');

Route::get('/login-kec', [UserKecController::class, 'index'])->middleware('Guest-kec');
Route::post('/login-kec', [UserKecController::class, 'authentication'])->middleware('Guest-kec');

Route::resource('/data-permintaan', PermintaanController::class)->middleware('custom-kec');
Route::post('/permintaan-form', [PermintaanController::class, 'store'])->middleware('custom-kec');


Route::post('/logout-kec', [UserKecController::class, 'logout'])->name('logout-kec')->middleware('custom-kec');

Route::get('/view-pdf/{filename}', function ($filename) {
    $path = storage_path('app/public/uploads/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    $file = file_get_contents($path);
    $type = mime_content_type($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
})->name('view-pdf');


Route::middleware([CustomMiddleware::class])->group(
    function () {



        Route::get('/dashboard', [DashboardController::class, 'index']);
        Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData'])->name('dashboard.chartData');
        Route::get('/dashboard/grafik-data', [DashboardController::class, 'grafikData'])->name('dashboard.grafikData');

        Route::resource('/data-gudang', GudangController::class);
        Route::resource('/data-kecamatan', KecamatanController::class);
        Route::resource('/data-biaya', BiayaController::class);
        Route::resource('/optimasi-biaya', PerhitunganVAMController::class);
        Route::resource('/data-distribusi', DistribusiController::class);
        Route::get('/permintaan-kec', [PermintaanController::class, 'show']);

        Route::post('/distribusi-form', [DistribusiController::class, 'store']);
        Route::post('/kecamatan-form', [KecamatanController::class, 'store']);
        Route::post('/gudang-form', [GudangController::class, 'store']);
        Route::post('/biaya-form', [BiayaController::class, 'store']);

        Route::get('/data-kecamatan/delete/{id}', [KecamatanController::class, 'delete']);
        Route::get('/data-gudang/delete/{id}', [GudangController::class, 'delete']);
        Route::get('/data-biaya/delete/{id}', [BiayaController::class, 'delete']);
        Route::get('/data-distribusi/delete/{id}', [DistribusiController::class, 'delete']);
        Route::get('/permintaan-kec/delete/{id}', [PermintaanController::class, 'delete']);

        Route::post('/data-kecamatan/edit/{id}', [KecamatanController::class, 'update']);
        Route::post('/data-gudang/edit/{id}', [GudangController::class, 'update']);
        Route::post('/data-biaya/edit/{id}', [BiayaController::class, 'update']);
        Route::post('/data-distribusi/edit/{id}', [DistribusiController::class, 'update']);


        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    }
);

// Route::resource('/data-gudang', GudangController::class);
// Route::resource('/data-kecamatan', KecamatanController::class);
// Route::resource('/data-biaya', BiayaController::class);
// Route::resource('/optimasi-biaya', PerhitunganVAMController::class);

// Route::resource('/data-distribusi', DistribusiController::class);

// Route::post('/distribusi-form', [DistribusiController::class, 'store']);
// Route::post('/kecamatan-form', [KecamatanController::class, 'store']);
// Route::post('/gudang-form', [GudangController::class, 'store']);
// Route::post('/biaya-form', [BiayaController::class, 'store']);

// Route::get('/data-kecamatan/delete/{id}', [KecamatanController::class, 'delete']);
// Route::get('/data-gudang/delete/{id}', [GudangController::class, 'delete']);
// Route::get('/data-biaya/delete/{id}', [BiayaController::class, 'delete']);

// Route::post('/data-kecamatan/edit/{id}', [KecamatanController::class, 'update']);
// Route::post('/data-gudang/edit/{id}', [GudangController::class, 'update']);
// Route::post('/data-biaya/edit/{id}', [BiayaController::class, 'update']);
