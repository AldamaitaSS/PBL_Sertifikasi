<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\SertifikasiController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [WelcomeController::class, 'index']); 

Route::group(['prefix' => 'pelatihan'], function() {
    Route::get('/', [PelatihanController::class, 'index']);
    Route::post('/list', [PelatihanController::class, 'list']);
    Route::get('/create', [PelatihanController::class, 'create']);
    Route::post('/', [PelatihanController::class,'store']);
    Route::get('/{id}', [PelatihanController::class, 'show']);
    Route::get('/{id}/edit', [PelatihanController::class, 'edit']);
    Route::put('/{id}', [PelatihanController::class, 'update']);
    Route::delete('/{id}', [PelatihanController::class, 'destroy']);
});

Route::group(['prefix' => 'sertifikasi'], function() {
    Route::get('/', [SertifikasiController::class, 'index']);
    Route::post('/list', [SertifikasiController::class, 'list']);
    Route::get('/create', [SertifikasiController::class, 'create']);
    Route::post('/', [SertifikasiController::class,'store']);
    Route::get('/{id}', [SertifikasiController::class, 'show']);
    Route::get('/{id}/edit', [SertifikasiController::class, 'edit']);
    Route::put('/{id}', [SertifikasiController::class, 'update']);
    Route::delete('/{id}', [SertifikasiController::class, 'destroy']);
});