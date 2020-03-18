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
Route::prefix('v1')->group(function(){
	Route::post('create', 'UserNewController@createAccount');
	Route::post('access', 'UserExistingController@accessAccount');
	Route::get('/verify/{token}', 'VerifyController@verifyEmail');
	Route::apiResource('pages', 'PageController');
	Route::apiResource('pages/content', 'PageContentController');
	
	Route::group(['middleware' => 'auth:api'], function() {
        Route::get('retrieveUser', 'UserExistingController@retrieveUser');
		Route::get('logout', 'UserExistingController@logout');
		Route::get('logoutFromAllDevice', 'UserExistingController@logoutFromAllDevice');
    });
});

Auth::routes(['verify' => true]);