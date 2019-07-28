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

Route::namespace('API')->group(function () {
    Route::get('/bosses/sincronizar', 'BossesController@getFromAPI')->name('bosses');
    Route::get('/bosses/{id?}', ['as' => 'bosses.get', 'uses' => 'BossesController@show']);
    Route::put('/bosses/{id}', 'BossesController@update');
    
    Route::get('/gyms/{id?}', ['as' => 'gyms.get', 'uses' => 'GymsController@show']);
    Route::post('/gyms/', 'GymsController@add');
    Route::put('/gyms/{id}', 'GymsController@update');
    
    Route::get('/raids/{id?}', ['as' => 'raids.get', 'uses' => 'RaidsController@show']);
    Route::post('/raids/', 'RaidsController@add');
    Route::put('/raids/{id}', 'RaidsController@update');
    Route::post('/raids/{id}', 'RaidsController@addTrainerToRaid');
    
    Route::get('/trainers/{id?}', ['as' => 'trainers.get', 'uses' => 'TrainersController@show']);
    Route::post('/trainers/', 'TrainersController@add');
    Route::put('/trainers/{id}', 'TrainersController@update');
});