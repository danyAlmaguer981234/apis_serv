<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserCalidadController;
use App\Http\Controllers\TaskController;

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
Route::apiResource('users', userCalidadController::class);
Route::apiResource('task', TaskController::class);

Route::get('/ubi', 'App\Http\Controllers\TaskController@getArtUbi');
Route::get('/woMstr', 'App\Http\Controllers\TaskController@getWoMstr');
Route::get('/client', 'App\Http\Controllers\TaskController@getClient');
Route::get('/clients', 'App\Http\Controllers\TaskController@getAllClient');
Route::get('/task', 'App\Http\Controllers\TaskController@getArt');
Route::get('/task', 'App\Http\Controllers\TaskController@index');
Route::POST('/task', 'App\Http\Controllers\TaskController@create');
Route::POST('/taskU', 'App\Http\Controllers\TaskController@updateAdd');
Route::POST('/deleted', 'App\Http\Controllers\TaskController@destroy');