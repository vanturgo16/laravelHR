<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);
     
Route::middleware('auth:api')->group( function () {
    Route::post('/create', 'App\Http\Controllers\API\CandidateController@Create');
    Route::get('/read', 'App\Http\Controllers\API\CandidateController@Read');
    Route::post('/update/{id}', 'App\Http\Controllers\API\CandidateController@Update');
    Route::post('/delete/{id}', 'App\Http\Controllers\API\CandidateController@Delete');
});