<?php

use Illuminate\Support\Facades\Route;
use App\Filament\Pages\Teacher\Assessments;
use App\Http\Controllers\PenilaianTkController;
use App\Http\Controllers\KMSemesterRaportController;
use App\Http\Controllers\P5BKPancasilaRaportController;

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

Route::redirect('/login', 'admin/login')->name('login');


Route::get('/preview-pancasila-raport', [P5BKPancasilaRaportController::class, 'previewPancasilaRaport'])->name('preview-pancasila-raport');
Route::get('/preview-semester-raport', [KMSemesterRaportController::class, 'previewSemesterRaport'])->name('preview-semester-raport');
// Route::prefix('teacher/print-report/semesters')->group(function () {
//     Route::get('/preview-semester-raport', [KMSemesterRaportController::class, 'previewSemesterRaport'])->name('preview-semester-raport');
// });
