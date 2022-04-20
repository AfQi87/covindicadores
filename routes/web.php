<?php

use App\Http\Controllers\Forms\SintomasController;
use App\Http\Controllers\Forms\VacunacionController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/forms/vacunacion', VacunacionController::class)->only(['index', 'create', 'store']);
Route::resource('/forms/sintomas', SintomasController::class)->only(['index', 'store', 'show']);
