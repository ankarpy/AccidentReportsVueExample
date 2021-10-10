<?php

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

Route::get('/', [App\Http\Controllers\ReportsController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('reports', App\Http\Controllers\ReportsController::class)->except('show');
Route::get('/reports/fetch', [App\Http\Controllers\ReportsController::class, 'fetch'])->name('reports.fetch');
Route::get('/reports/{slug}', [App\Http\Controllers\ReportsController::class, 'show'])->name('reports.show');


