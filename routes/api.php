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
    Route::post('/register', 'PassportController@register');
    Route::post('/login', 'PassportController@login');
    
    Route::get('/bosses/sincronizar', 'BossesController@getFromAPI')->name('bosses')->middleware('auth:api');
    Route::get('/bosses/search', 'BossesController@search');
    Route::get('/bosses/{id?}', ['as' => 'bosses.get', 'uses' => 'BossesController@show']);
    Route::put('/bosses/{id}', 'BossesController@update')->middleware('auth:api');
    
    Route::get('/gyms/{id?}', ['as' => 'gyms.get', 'uses' => 'GymsController@show']);
    Route::post('/gyms/', 'GymsController@add')->middleware('auth:api');
    Route::put('/gyms/{id}', 'GymsController@update')->middleware('auth:api');
    
    Route::get('/raids/{id?}', ['as' => 'raids.get', 'uses' => 'RaidsController@show']);
    Route::post('/raids/', 'RaidsController@add');
    Route::put('/raids/{id}', 'RaidsController@update');
    Route::post('/raids/{id}', 'RaidsController@addTrainerToRaid');
    Route::delete('/raids/{id}/{nickname}', 'RaidsController@removeTrainerFromList');
    
    Route::get('/trainers/{id?}', ['as' => 'trainers.get', 'uses' => 'TrainersController@show']);
    Route::post('/trainers/', 'TrainersController@add');
    Route::put('/trainers/{id}', 'TrainersController@update');
});