<?php

use App\Http\Controllers\ProjectByRegion;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectReportController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportStudioController;
use App\Http\Controllers\RoleController;
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
    'register' => false, // Register Routes...

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
Route::resource('usuarios', UserController::class)->except('show')->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                               Project Routes                               */
/* -------------------------------------------------------------------------- */
Route::resource('proyectos', ProjectController::class)->except('show', 'index', 'create')->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                                Region Routes                               */
/* -------------------------------------------------------------------------- */
Route::resource('regiones', RegionController::class)->except('show')->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                              Study Routes                                  */
/* -------------------------------------------------------------------------- */


Route::resource('estudios', StudyController::class)->except('show')->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                                Upload File Route                           */
/* -------------------------------------------------------------------------- */
Route::get('/lista-estudios/proyecto/{id}', [ReportController::class, 'studiesList'])->name('studies-list')->middleware('can:studies-list')->middleware('auth');
Route::get('/lista-estudios/proyecto/{id}/estudio/{idStudio}/lista-reportes', [ReportController::class, 'reportsList'])->name('reports-list')->middleware('can:reports-list')->middleware('auth');
Route::get('/subir-informes/proyecto/{id}/estudio/{idStudio}', [ReportController::class, 'uploadReports'])->name('upload-reports')->middleware('can:upload-reports')->middleware('auth');
Route::get('/proyecto/{idProject}/estudio/{idStudio}/consultar-informes/{idReport}', [ReportController::class, 'showInforms'])->name('show-informs')->middleware('can:show-informs')->middleware('auth');
Route::get('descargar-archivo/{idProject}/{idStudio}/{idReport}/{nameFile}', [ReportController::class, 'downloadFile'])->name('downloadFile')->middleware('can:downloadFile')->middleware('auth');
Route::get('eliminar-archivo/{idProject}/{idStudio}/{idReport}/{nameFile}', [ReportController::class, 'deleteFile'])->name('deleteFile')->middleware('can:deleteFile')->middleware('auth');
Route::get('eliminar-directorio-estudio/{idProject}/{idStudio}', [ReportController::class, 'deleteStudioDirectory'])->name('deleteStudioDirectory')->middleware('can:deleteStudioDirectory')->middleware('auth');
Route::get('eliminar-directorio-reporte/{idProject}/{idStudio}/{idReport}', [ReportController::class, 'deleteReportsDirectory'])->name('deleteReportsDirectory')->middleware('can:deleteReportsDirectory')->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                                Report Route                                */
/* -------------------------------------------------------------------------- */
Route::resource('informes', ReportStudioController::class)->only(['store', 'update'])->middleware('auth');
Route::get('informes-editar/{id}/estudio/{idStudio}/proyecto/{idProject}', [ReportController::class, 'reportEdit'])->name('report-edit')->middleware('can:report-edit')->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                                 Roles Route                                */
/* -------------------------------------------------------------------------- */
Route::resource('roles', RoleController::class)->except('show')->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                                 Query Route                                */
/* -------------------------------------------------------------------------- */
Route::get('/consulta-proyectos-iniciar', [ProjectReportController::class, 'projectStart'])->middleware('can:show.reports')->name('projectStart')->middleware('auth');
Route::get('/consulta-proyectos-en-procesos', [ProjectReportController::class, 'projectInProcess'])->middleware('can:show.reports')->name('projectInProcess')->middleware('auth');
Route::get('/consulta-proyectos-concluidos', [ProjectReportController::class, 'completedProject'])->middleware('can:show.reports')->name('completedProject')->middleware('auth');
Route::get('/consulta-proyectos-por-region', [ProjectReportController::class, 'showRegionForm'])->middleware('can:show.reports')->name('showRegionForm')->middleware('auth');
Route::get('/grafica-proyectos-por-region', [ProjectReportController::class, 'showPiechartbyRegion'])->middleware('can:show.reports')->name('showPiechartbyRegion')->middleware('auth');
Route::get('/proyectos-por-region/{id}', [ProjectByRegion::class, 'projectByRegion'])->middleware('can:proyectos.index')->name('projectByRegion')->middleware('auth');
Route::get('/busqueda-proyectos/{id}', [ProjectByRegion::class, 'searchProjectByRegion'])->middleware('can:proyectos.index')->name('searchProjectByRegion')->middleware('auth');
Route::get('/proyectos/crear/region/{id}', [ProjectByRegion::class, 'createProjectByRegion'])->middleware('can:proyectos.create')->name('createProjectByRegion')->middleware('auth');
