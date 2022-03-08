<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportStudioController;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
/* -------------------------------------------------------------------------- */
/*                                 Auth Routes                                */
/* -------------------------------------------------------------------------- */

Auth::routes([
    'register' => true, // Register Routes...

    'reset' => false, // Reset Password Routes...

    'verify' => false, // Email Verification Routes...
]);
/* --------------------------------------------------------------------------  */
/*                                 Home Routes                                 */
/* --------------------------------------------------------------------------  */
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                                 User Routes                                */
/* -------------------------------------------------------------------------- */
Route::resource('usuarios', UserController::class)->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                               Project Routes                               */
/* -------------------------------------------------------------------------- */
Route::resource('proyectos', ProjectController::class)->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                                Region Routes                               */
/* -------------------------------------------------------------------------- */
Route::resource('regiones', RegionController::class)->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                              Study Routes                                  */
/* -------------------------------------------------------------------------- */
Route::resource('estudios', StudyController::class)->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                                Upload File Route                           */
/* -------------------------------------------------------------------------- */
Route::get('/lista-estudios/proyecto/{id}', [ReportController::class, 'studiesList'])->name('studies-list')->middleware('auth'); //ok
Route::get('/lista-estudios/proyecto/{id}/estudio/{idStudio}/lista-reportes', [ReportController::class, 'reportsList'])->name('reports-list')->middleware('auth');
Route::get('/subir-informes/proyecto/{id}/estudio/{idStudio}', [ReportController::class, 'uploadReports'])->name('upload-reports')->middleware('auth');
Route::get('/proyecto/{idProject}/estudio/{idStudio}/consultar-informes/{idReport}', [ReportController::class, 'showInforms'])->name('show-informs')->middleware('auth');
Route::get('descargar-archivo/{idProject}/{idStudio}/{idReport}/{nameFile}', [ReportController::class, 'downloadFile'])->name('downloadFile')->middleware('auth');
Route::get('eliminar-archivo/{idProject}/{idStudio}/{idReport}/{nameFile}', [ReportController::class, 'deleteFile'])->name('deleteFile')->middleware('auth');

/* -------------------------------------------------------------------------- */
/*                                Report Route                                */
/* -------------------------------------------------------------------------- */
Route::resource('informes', ReportStudioController::class)->middleware('auth');
