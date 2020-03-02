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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/info/get-data', 'Api\InfoController@index');
Route::get('/info/{id}/get-data', 'Api\InfoController@show');

Route::post('/info/post-data', 'Api\InfoController@store');
Route::post('/info/{id}/update-data/', 'Api\InfoController@update');
Route::delete('/info/{id}/delete-data/', 'Api\InfoController@destroy');
