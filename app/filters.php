<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
    \Security\Helpers\LogHelper::beginRequest();
});


App::after(function($request, $response)
{
    \Security\Helpers\LogHelper::endRequest();
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() !== Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});

/**
 * 为返回的结果header中添加Request ID字段
 */
Route::filter('rqid', function($route, $request, $response) {
    $response->headers->set('rqid', \Security\Helpers\LogHelper::getRequestId());
});

Route::filter('authority', function($route, $request, $type = null) {
    if (is_null($type)) {
        if (Auth::id() !== 1) {
            return Response::make('Unauthorized', 401);
        }
    } elseif ($type == '1') {
        if (\Security\Models\User::getAuthorityById(Auth::id())->add_user == 0) {
            return Response::make('Unauthorized', 401);
        }
    } elseif ($type == '2') {
        if (\Security\Models\User::getAuthorityById(Auth::id())->modify_user == 0) {
            return Response::make('Unauthorized', 401);
        }
    } elseif ($type == '3') {
        if (\Security\Models\User::getAuthorityById(Auth::id())->add_role == 0) {
            return Response::make('Unauthorized', 401);
        }
    } elseif ($type == '4') {
        if (\Security\Models\User::getAuthorityById(Auth::id())->modify_role == 0) {
            return Response::make('Unauthorized', 401);
        }
    } elseif ($type == '5') {
        if (\Security\Models\User::getAuthorityById(Auth::id())->show == 0) {
            return Response::make('Unauthorized', 401);
        }
    }
});
