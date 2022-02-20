<?php

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
*/
//home
Route::get('/', function () {
    return view('auth.login');
});

// Auth::routes();
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
Route::get('/home', [
    App\Http\Controllers\HomeController::class,
    'index',
])->name('home');
/* -------------------------------------------------------------------------- */
/*                                 User Routes                                */
/* -------------------------------------------------------------------------- */
Route::resource('usuarios', UserController::class)->middleware('auth');
