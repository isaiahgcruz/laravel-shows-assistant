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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::resource('users.shows', 'ShowController',
        ['only' => ['index', 'store']]);

Route::resource('episodes', 'EpisodeController',
        ['only' => ['index']]);

Route::resource('episodes/upcoming', 'EpisodeController@upcoming');
Route::post('episodes/refresh', 'EpisodeController@refreshEpisodes');