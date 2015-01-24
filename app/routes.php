<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

use Security\Models\User;

Route::get('/', function()
{
	return View::make('hello');
});


Route::group(array(
    'namespace' => 'Security\Controllers',
    'after' => 'rqid',
), function() {
    Route::get('login', 'UserController@getLogin');
    Route::post('login', 'UserController@postLogin');
    Route::any('logout', 'UserController@logout');
    Route::any('verify_code', 'VerifyCodeController@getCode');

    Route::group(array('before' => 'auth'), function() {
        Route::any('dashboard', 'FunctionController@dashboard');

        Route::any('test', function() {
            return Response::json(User::getAuthorityById(Auth::user()->id));
        });

        Route::group(array('prefix' => 'user'), function() {
            Route::group(array('before' => 'authority:1'), function() {
                Route::get('add', 'UserController@getAdd');
                Route::post('add', 'UserController@postAdd');
            });
            Route::group(array('before' => 'authority:2'), function() {
                Route::get('modify', 'UserController@getModify');
                Route::post('modify', 'UserController@postModify');
            });
            Route::group(array('before' => 'authority'), function() {
                Route::get('unlock', 'UserController@getUnlock');
                Route::post('unlock', 'UserController@postUnlock');
            });
        });

        Route::group(array('prefix' => 'role'), function() {
            Route::group(array('before' => 'authority:3'), function() {
                Route::any('add', 'RoleController@add');
            });
            Route::group(array('before' => 'authority:4'), function() {
                Route::any('modify', 'RoleController@modify');
            });
        });

        Route::group(array('before' => 'authority:5'), function() {
            Route::any('show', 'FunctionController@show');
        });
    });
});
