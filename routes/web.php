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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*
 * Masters Routes
 */
Route::resource('masters', App\Http\Controllers\MasterController::class);

/*
 * Mothers Routes
 */
Route::resource('mothers', App\Http\Controllers\MotherController::class);

/*
 * Brothers Routes
 */
Route::resource('brothers', App\Http\Controllers\BrotherController::class);
