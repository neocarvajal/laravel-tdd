<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/videos/{id}', 'App\Http\Controllers\VideosController@get');

Route::get('/videos', 'App\Http\Controllers\VideosController@index');

Route::get('/series', 'App\Http\Controllers\SeriesController@index');

Route::get('/series/{serie}/videos', 'App\Http\Controllers\VideoSerieController@index');