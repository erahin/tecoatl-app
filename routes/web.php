<?php

use App\Http\Controllers\AdministrativeController;
use App\Http\Controllers\DocumentAdministrativeController;
use App\Http\Controllers\ExecutiveController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\ProjectByRegion;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectReportController;
use App\Http\Controllers\PublicController;
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
// /* -------------------------------------------------------------------------- */
// /*                                 Login Route                                */
// /* -------------------------------------------------------------------------- */
// Route::get('/reload-captcha', [App\Http\Controllers\Auth\LoginController::class, 'reloadCaptcha']);
/* -------------------------------------------------------------------------- */
/*                                   / Route                                  */
/* -------------------------------------------------------------------------- */
Route::get('/', function () {
    return view('welcome');
})->name('root');
Route::get('/enviar-codigo', [App\Http\Controllers\Auth\LoginController::class, 'sendCode'])->name('sendCode');
Route::get('/intentar-enviar-codigo', [App\Http\Controllers\Auth\LoginController::class, 'trySendCode'])->name('trySendCode');
/* --------------------------------------------------------------------------  */
/*                                 Home Routes                                 */
/* --------------------------------------------------------------------------  */
Route::get('/inicio', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('inicio')
    ->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                                 User Routes                                */
/* -------------------------------------------------------------------------- */
Route::resource('usuarios', UserController::class)->except('show')->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                               Project Routes                               */
/* -------------------------------------------------------------------------- */
Route::resource('proyectos', ProjectController::class)
    ->except('show', 'index', 'create')
    ->middleware('auth');
Route::get('/proyectos-por-region/{id}', [ProjectByRegion::class, 'projectByRegion'])
    ->middleware('can:proyectos.index')
    ->name(
        'projectByRegion'
    )->middleware('auth');
Route::get('/busqueda-proyectos/{id}', [ProjectByRegion::class, 'searchProjectByRegion'])
    ->middleware('can:proyectos.index')
    ->name(
        'searchProjectByRegion'
    )->middleware('auth');
Route::get('/proyectos/crear/region/{id}', [ProjectByRegion::class, 'createProjectByRegion'])
    ->middleware('can:proyectos.create')
    ->name('createProjectByRegion')
    ->middleware('auth');
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
Route::get('/lista-estudios/proyecto/{id}', [ReportController::class, 'studiesList'])
    ->name('studies-list')->middleware('can:studies-list')
    ->middleware('auth');
Route::get('/lista-estudios/proyecto/{id}/estudio/{idStudio}/lista-reportes', [ReportController::class, 'reportsList'])
    ->name('reports-list')->middleware('can:reports-list')
    ->middleware('auth');
Route::get('/subir-informes/proyecto/{id}/estudio/{idStudio}', [ReportController::class, 'uploadReports'])
    ->name('upload-reports')->middleware('can:upload-reports')
    ->middleware('auth');
Route::get('/proyecto/{idProject}/estudio/{idStudio}/consultar-informes/{idReport}', [ReportController::class, 'showInforms'])
    ->name('show-informs')->middleware('can:show-informs')
    ->middleware('auth');
Route::get('descargar-archivo/{idProject}/{idStudio}/{idReport}/{nameFile}', [ReportController::class, 'downloadFile'])
    ->name('downloadFile')->middleware(
        'can:downloadFile'
    )->middleware('auth');
Route::get('eliminar-archivo/{idProject}/{idStudio}/{idReport}/{nameFile}', [ReportController::class, 'deleteFile'])
    ->name('deleteFile')->middleware('can:deleteFile')
    ->middleware('auth');
Route::get('eliminar-directorio-estudio/{idProject}/{idStudio}', [ReportController::class, 'deleteStudioDirectory'])
    ->name('deleteStudioDirectory')->middleware('can:deleteStudioDirectory')
    ->middleware('auth');
Route::get('eliminar-directorio-reporte/{idProject}/{idStudio}/{idReport}', [ReportController::class, 'deleteReportsDirectory'])
    ->name('deleteReportsDirectory')->middleware('can:deleteReportsDirectory')
    ->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                                Report Route                                */
/* -------------------------------------------------------------------------- */
Route::resource('informes', ReportStudioController::class)->only(['store', 'update'])->middleware('auth');
Route::get('informes-editar/{id}/estudio/{idStudio}/proyecto/{idProject}', [ReportController::class, 'reportEdit'])
    ->name('report-edit')->middleware('can:report-edit')->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                             Query report Route                             */
/* -------------------------------------------------------------------------- */
Route::get('/lista-informes-por-usuario', [ReportController::class, 'reportWithUser'])
    ->name('reportWithUser')->middleware('can:show.reports')
    ->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                                 Roles Route                                */
/* -------------------------------------------------------------------------- */
Route::resource('roles', RoleController::class)->except('show')->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                                 Query Route                                */
/* -------------------------------------------------------------------------- */
Route::get('/consulta-proyectos-iniciar', [ProjectReportController::class, 'projectStart'])->middleware('can:show.reports')
    ->name('projectStart')
    ->middleware('auth');
Route::get('/consulta-proyectos-en-procesos', [ProjectReportController::class, 'projectInProcess'])->middleware('can:show.reports')
    ->name('projectInProcess')
    ->middleware('auth');

Route::get('/consulta-proyectos-concluidos', [ProjectReportController::class, 'completedProject'])->middleware('can:show.reports')
    ->name('completedProject')
    ->middleware('auth');

Route::get('/grafica-proyectos-por-region', [ProjectReportController::class, 'showPiechartbyRegion'])->middleware('can:show.reports')
    ->name('showPiechartbyRegion')
    ->middleware('auth');
Route::get('/lista-proyectos-por-usuario', [ProjectReportController::class, 'projectWithUser'])
    ->name('projectWithUser')->middleware('can:show.reports')
    ->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                              Route departament                             */
/* -------------------------------------------------------------------------- */
Route::resource('administrativos', AdministrativeController::class)->middleware('auth')->except('show');
/* -------------------------------------------------------------------------- */
/*                         Route folder and subfolder                         */
/* -------------------------------------------------------------------------- */
// First nivel //
Route::get('/crear-carpeta/administrativo/{idAdministrative}', [DocumentAdministrativeController::class, 'createFolder'])
    ->name('createFolder')->middleware('can:createFolder')->middleware('auth');
Route::post('/store/{idAdministrative}', [DocumentAdministrativeController::class, 'storeFolder'])->name('storeFolder')
    ->middleware('can:createFolder')->middleware('auth');
Route::get('/lista-carpetas/administrativo/{idAdministrative}', [DocumentAdministrativeController::class, 'folderList'])->name('folderList')
    ->middleware('can:folderList')->middleware('auth');
// Second nivel //
Route::get('/subir-archivo/administrativo/{idAdministrative}/{folder}', [DocumentAdministrativeController::class, 'showFormUploadFile'])
    ->name('showFormUploadFile')->middleware('can:showFormUploadFile')->middleware('auth');
Route::post('/upload-file/{idAdministrative}/{folder}', [DocumentAdministrativeController::class, 'uploadFile'])
    ->name('uploadFile')->middleware('can:showFormUploadFile')->middleware('auth');
Route::get('/lista-archivos/administrativo/{idAdministrative}/{folder}', [DocumentAdministrativeController::class, 'fileList'])
    ->name('fileList')->middleware('can:fileList')->middleware('auth');
Route::get('/crear-subcarpeta/administrativo/{idAdministrative}/{folder}', [DocumentAdministrativeController::class, 'createSubFolder'])
    ->name('createSubFolder')->middleware('can:createFolder')->middleware('auth');
Route::post('/store-sub-folder/{idAdministrative}/{folder}', [DocumentAdministrativeController::class, 'storeSubFolder'])
    ->name('storeSubFolder')->middleware('can:createFolder')->middleware('auth');
Route::get('/lista-subcarpetas/administrativo/{idAdministrative}/{folder}', [DocumentAdministrativeController::class, 'subFolderList'])
    ->name('subFolderList')->middleware('can:folderList')->middleware('auth');
Route::get('eliminar-directorio/{idAdministrative}/{folder}', [DocumentAdministrativeController::class, 'deleteFolder'])
    ->name('deleteFolder')->middleware('can:deleteFolder')->middleware('auth');
// Third level //
Route::get('descargar-archivo/{idAdministrative}/{folder}/{file}', [DocumentAdministrativeController::class, 'downloadFileFolder'])
    ->name('downloadFileFolder')->middleware('can:downloadFileFolder')->middleware('auth');
Route::get('eliminar-archivo/{idAdministrative}/{folder}/{file}', [DocumentAdministrativeController::class, 'deleteFileFolder'])
    ->name('deleteFileFolder')->middleware('can:deleteFileFolder')->middleware('auth');
// Fourth level //
Route::get('/subir-archivo/administrativo/{idAdministrative}/{folder}/{subfolder}', [DocumentAdministrativeController::class, 'showFormUploadFileSubFolder'])
    ->name('showFormUploadFileSubFolder')->middleware('can:showFormUploadFile')->middleware('auth');
Route::post('/upload-file/administrativo/{idAdministrative}/{folder}/{subfolder}', [DocumentAdministrativeController::class, 'uploadFileSubFolder'])
    ->name('uploadFileSubFolder')->middleware('can:showFormUploadFile')->middleware('auth');
Route::get('/lista-archivos/administrativo/{idAdministrative}/{folder}/{subfolder}', [DocumentAdministrativeController::class, 'subFolderFileList'])
    ->name('subFolderFileList')->middleware('can:fileList')->middleware('auth');
Route::get('eliminar-directorio-sub-folder/{idAdministrative}/{folder}/{subfolder}', [DocumentAdministrativeController::class, 'deleteSubFolder'])
    ->name('deleteSubFolder')->middleware('can:deleteFolder')->middleware('auth');
Route::get('descargar-archivo-sub-folder/{idAdministrative}/{folder}/{subfolder}/{file}', [DocumentAdministrativeController::class, 'downloadFileSubFolder'])
    ->name('downloadFileSubFolder')->middleware('can:downloadFileFolder')->middleware('auth');
Route::get('eliminar-archivo-sub-folder/{idAdministrative}/{folder}/{subfolder}/{file}', [DocumentAdministrativeController::class, 'deleteFileSubFolder'])
    ->name('deleteFileSubFolder')->middleware('can:deleteFileFolder')->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                                 Route legal                                */
/* -------------------------------------------------------------------------- */
Route::resource('legal', LegalController::class)->middleware('auth')->except('show');
/* -------------------------------------------------------------------------- */
/*                                Route public                                */
/* -------------------------------------------------------------------------- */
Route::get('público', [PublicController::class, 'index'])->name('publico.index')->middleware('can:publico.index')->middleware('auth');
Route::get('público/crear', [PublicController::class, 'create'])->name('createFolderPublic')->middleware('can:createFolderPublic')->middleware('auth');
Route::post('público/store-carpeta', [PublicController::class, 'store'])->name('store')->middleware('can:createFolderPublic')->middleware('auth');
Route::get('público/eliminar-carpeta/{path}', [PublicController::class, 'deleteFolder'])->name('publico.destroy')->middleware('can:publico.destroy')->middleware('auth');
Route::get('público/subir-archivos/{path}', [PublicController::class, 'uploadFileForm'])->name('uploadFileForm')->middleware('can:uploadFileForm')->middleware('auth');
Route::post('público/store-archivos/{path}', [PublicController::class, 'uploadPublicFile'])->name('uploadPublicFile')->middleware('can:uploadFileForm')->middleware('auth');
Route::get('público/listar-archivos/{path}', [PublicController::class, 'publicFilesList'])->name('publicFilesList')->middleware('can:publicFilesList')->middleware('auth');
Route::get('público/descargar/{folder}/{subfolder}/{file}', [PublicController::class, 'downloadPublicFile'])->name('downloadPublicFile')->middleware('can:downloadPublicFile')->middleware('auth');
Route::get('público/eliminar/{folder}/{subfolder}/{file}', [PublicController::class, 'deletePublicFile'])->name('deletePublicFile')->middleware('can:deletePublicFile')->middleware('auth');
// Route::get('público/crear-carpeta/{path}', [PublicController::class, 'createFolder'])->name('publico.create')->middleware('auth');
// Route::post('público/store-carpeta/{path}/{route}', [PublicController::class, 'storeFolder'])->name('publico.store')->middleware('auth');
/* -------------------------------------------------------------------------- */
/*                               Route executive                              */
/* -------------------------------------------------------------------------- */
Route::get('directivo', [ExecutiveController::class, 'index'])->name('directivo.index')->middleware('can:directivo.index')->middleware('auth');
Route::get('directivo/crear', [ExecutiveController::class, 'create'])->name('directivo.create')->middleware('can:directivo.create')->middleware('auth');
Route::post('directivo/store', [ExecutiveController::class, 'store'])->name('directivo.store')->middleware('can:directivo.create')->middleware('auth');
Route::get('directivo/subir-archivos/{path}', [ExecutiveController::class, 'uploadFileForm'])->name('directivo.createUpload')->middleware('can:directivo.createUpload')->middleware('auth');
Route::post('directivo/store-archivos/{path}', [ExecutiveController::class, 'uploadExecutiveFile'])->name('directivo.upload')->middleware('can:directivo.createUpload')->middleware('auth');
Route::get('directivo/listar-archivos/{path}', [ExecutiveController::class, 'executiveFilesList'])->name('directivo.fileList')->middleware('can:directivo.fileList')->middleware('auth');
Route::get('directivo/descargar/{folder}/{subfolder}/{file}', [ExecutiveController::class, 'downloadExecutiveFile'])->name('directivo.download')->middleware('can:directivo.download')->middleware('auth');
Route::get('directivo/eliminar/{folder}/{subfolder}/{file}', [ExecutiveController::class, 'deleteExecutiveFile'])->name('directivo.deleteFile')->middleware('can:directivo.deleteFile')->middleware('auth');
Route::get('directivo/eliminar-carpeta/{path}', [ExecutiveController::class, 'deleteFolder'])->name('directivo.destroy')->middleware('can:directivo.destroy')->middleware('auth');
/* Second Module */
Route::get('directivo/crear-carpeta/{path}', [ExecutiveController::class, 'createFolder'])->name('directivo.create-subfolder')->middleware('auth');
Route::post('directivo/store-carpeta/{path}', [ExecutiveController::class, 'storeFolder'])->name('directivo.store-subfolder')->middleware('auth');
Route::get('directivo/lista-carpetas/{path}', [ExecutiveController::class, 'folderList'])->name('directivo.folder-list')->middleware('auth');
