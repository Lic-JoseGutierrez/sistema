<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnoController;

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
Route::resource('alumno', AlumnoController::class)->middleware('auth'); 
Auth::routes(['reset'=>false]); 
Route::get('/home', [AlumnoController::class, 'index'])->name('home'); 
Route::group(['middleware' => 'auth'], function () { 
Route::get('/', [AlumnoController::class, 'index'])->name('home'); 
});
