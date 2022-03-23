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

//login
Route::get('/', 'App\Http\Controllers\AuthController@login')->name('login');
Route::post('/postlogin', 'App\Http\Controllers\AuthController@postlogin');
Route::get('/logout', 'App\Http\Controllers\AuthController@logout');

Route::group(['middleware'=>'auth'],function() {
    //home
    Route::get('/home', 'App\Http\Controllers\HomeController@index');

    //menu
    Route::post('/candidates/store', 'App\Http\Controllers\MenuController@storeCandidate')->name('candidate.store');
    Route::get('/candidates', 'App\Http\Controllers\MenuController@indexCandidate');
    Route::post('/candidates/update', 'App\Http\Controllers\MenuController@updateCandidate');
    Route::get('/candidates/delete/{id}', 'App\Http\Controllers\MenuController@deleteCandidate')->name('candidate.delete');
});
