<?php

// Route::get('/contoh-sms', function(){
// 	$sms = App\Setting::sms();
// 	$curl = curl_init();
// 	curl_setopt_array($curl, array(
// 		CURLOPT_URL => config('sms.api'),
// 		CURLOPT_RETURNTRANSFER => true,
// 		CURLOPT_ENCODING => "",
// 		CURLOPT_MAXREDIRS => 10,
// 		CURLOPT_TIMEOUT => 30,
// 		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
// 		CURLOPT_CUSTOMREQUEST => 'POST',
// 		CURLOPT_POSTFIELDS => "[  " . json_encode([
// 			'phone_number'=>'085322778935',
// 			'message'=>'Hai anam, apa kabar? sehat kan? semoga apa yang kamu inginkan tercapai. Amiin',
// 			'device_id'=>95703
// 		]) . "]",
// 		CURLOPT_HTTPHEADER => array(
// 			"authorization: ".config('sms.token'),
// 			"cache-control: no-cache"
// 		),
// 	));
// 	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
// 	$response = json_decode(curl_exec($curl),true);
// 	curl_close($curl);
// 	return $response;
// });

Route::group(['middleware' => ['must_logout']], function(){

	Route::middleware('buat_aktivitas')->group(function(){

	# USER PROFILE TANPA LOGIN
		Route::get('/profile/{username}', 'ListUserController@profile');

		Route::get('/clear-sliders', 'Admin\SliderController@clear');

		Route::get('/contents/attachment/{url}', 'ContentController@attachment');

	# MENU USER TANPA LOGIN
		Route::get('/', 'HomeController@index');
		Route::get('/home', 'HomeController@index')->name('home');
		Route::get('/user-verification/{id}', 'AutentikasiController@verifyForm');

		Route::get('/login', 'AutentikasiController@loginForm')->name('user_login');

		Route::group(['prefix' => 'contents'], function(){
			Route::get('/', 'ContentController@contents');
			Route::get('/with-category/{category}', 'ContentController@withCategory');
			Route::get('/with-tag/{tag}', 'ContentController@withTag');
			Route::get('/{content_kind}', 'ContentController@all')->name('contents');
			Route::get('/{content_kind}/{content}', 'ContentController@detail')
			->middleware('content')
			->name('contents.detail');
		});

		Route::group(['prefix' => 'pages'], function(){
			Route::get('/with-tag/{tag}', 'PageController@withTag');
			Route::get('/{page_kind}', 'PageController@all');
			Route::get('/{page_kind}/{url}', 'PageController@detail')->name('pages.detail');
		});

		Route::group(['prefix' => 'feedback'], function(){
			Route::get('/with-tag/{tag}', 'FeedbackController@withTag');
			Route::get('/{feedback_kind}', 'FeedbackController@all');
			Route::get('/{feedback_kind}/{feedback}', 'FeedbackController@detail')->name('feedback.detail');
		});

	});

});

//======================================================================================================//


# ADMIN AREA
Route::prefix('administrator')->group(function(){
	Auth::routes();
});

Route::get('/set-tentang', 'Admin\SettingController@setAbout');

Route::get('/set-our-focus', 'Admin\SettingController@setOurFocus');