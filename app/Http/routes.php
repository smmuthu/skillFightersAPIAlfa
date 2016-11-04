<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::group(['prefix' => 'api/v1', 'middleware' => ['jwt.auth']], function()
Route::group(['prefix' => 'api/v1'], function()
{
	
	Route::post('authenticate', 'AuthenticateController@authenticate');
	Route::get('authenticate/user', 'AuthenticateController@getAuthenticatedUser');
    Route::resource('user', 'AccountController');
    Route::post('user/resetpassword', 'AccountController@resetpassword');
});