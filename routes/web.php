<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpecterController;
use App\Http\Controllers\PVController;
use App\Http\Controllers\CircularController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PdfController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');*/

Route::get('/dashboard', [HomeController::class, 'dashboard']);

require __DIR__.'/auth.php';

/*************************** Profile Controller ********************************/

Route::post('/submitsearch', [SpecterController::class, 'submitsearch']);

Route::get('/compare', [SpecterController::class, 'compare']);

Route::post('/submitcompare', [SpecterController::class, 'submitcompare']);

Route::get('/history', [SpecterController::class, 'history']);

Route::get('/gentities', [SpecterController::class, 'gentities']);

Route::get('/sentities', [SpecterController::class, 'sentities']);

Route::get('/usertable', [SpecterController::class, 'usertable']);






