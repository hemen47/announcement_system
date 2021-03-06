<?php

use Illuminate\Http\Request;

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


Route::get('jobs', 'JobsController@index');
Route::post('login', 'JobsController@login');
Route::post('panel', 'JobsController@save');
Route::post('reserve', 'JobsController@reserve');
