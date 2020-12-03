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
	Route::post('access', 'UserController@accessAccount');
	Route::get('verify/{token}', 'UserController@verifyEmail')->name('verify');
	Route::apiResource('pages', 'PageController');
	Route::apiResource('pages/content', 'PageContentController');

	Route::group(['middleware' => 'auth:api'], function() {
		Route::get('profile', 'UserController@profile');
        Route::get('profile/{id}', 'UserController@profileById');
        Route::post('profile/update/detail', 'UserController@updateProfileDetail');
        Route::post('profile/update/slide', 'UserController@updateProfileSlide');
        Route::post('profile/update/contact', 'UserController@updateProfileContact');

		Route::get('user/partners', 'UserController@getPartnerData');

		Route::get('user/request', 'UserController@getMyRequests');
		Route::get('user/offer', 'UserController@getMyOffers');
		Route::get('user/mail', 'UserController@getMyMail');
		Route::get('user/matchmakers', 'UserController@getMyMatchmakers');

		Route::get('user/notifications', 'UserController@getMyNotifications')->name('notifications');

		Route::post('partner/request', 'PartnerController@requestPartnership');
		Route::post('partner/confirm', 'PartnerController@confirmPartner');
		Route::post('partner/remove', 'PartnerController@removePartner');
		Route::post('partner/block', 'PartnerController@blockPartner');

		Route::apiResource('trader/request', 'RequestTraderController');
		Route::apiResource('trader/offer', 'RequestOfferController');
		Route::apiResource('trader/mail', 'RequestMailController');
		Route::apiResource('trader/matchmaker', 'RequestMatchMakerController');

		Route::get('notification/clear', 'NotificationController@clearMyNotifications');
		Route::get('notification/remove/{id}', 'NotificationController@removeNotifications');

		Route::get('logout', 'UserController@logout');
		Route::get('logoutFromAllDevice', 'UserController@logoutFromAllDevice');
    });
});

Auth::routes(['verify' => true]);
