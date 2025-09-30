<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DemandController;
use App\Http\Controllers\DemandAttachmentController;
use App\Http\Controllers\CompanyCredentialController;
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

Route::get('/', function () {
    return view('welcome');
});

// Empresas / Demandas
Route::get('/empresa/{slug}', [DemandController::class, 'index'])->name('empresa.show');
Route::post('/empresa/{slug}', [DemandController::class, 'store'])->middleware('auth')->name('empresa.demands.store');

Route::put('/demands/{demand}', [DemandController::class, 'update'])->middleware('auth')->name('demands.update');
Route::delete('/demands/{demand}', [DemandController::class, 'destroy'])->middleware('auth')->name('demands.destroy');
Route::delete('/attachments/{attachment}', [DemandAttachmentController::class, 'destroy'])->middleware('auth')->name('attachments.destroy');

// Credenciais por empresa
Route::get('/credenciais', [CompanyCredentialController::class, 'hub'])->middleware('auth')->name('credentials.hub');
Route::get('/empresa/{slug}/credenciais', [CompanyCredentialController::class, 'index'])->middleware('auth')->name('empresa.credentials.index');
Route::post('/empresa/{slug}/credenciais', [CompanyCredentialController::class, 'store'])->middleware('auth')->name('empresa.credentials.store');
Route::put('/credenciais/{credential}', [CompanyCredentialController::class, 'update'])->middleware('auth')->name('empresa.credentials.update');
Route::delete('/credenciais/{credential}', [CompanyCredentialController::class, 'destroy'])->middleware('auth')->name('empresa.credentials.destroy');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
