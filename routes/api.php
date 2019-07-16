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

Route::middleware(['auth:api', 'cors'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'cors'], function() {
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login')->name('login');

    Route::apiResource('books', 'BookController');
    Route::post('books/{book}/ratings', 'RatingController@store');
});
