<?php

# GET LOGO
Route::get('/logo', 'Admin\WebSettingController@logo');

Route::post('/upload-snote', 'SummernoteController');

Route::get('/menu-setting/font-type', 'Admin\MenuController@fontType');
Route::get('/menu/{all?}', 'Admin\MenuController@api');
Route::get('/web', 'Admin\SettingController@web');

Route::post('/check-email', 'AutentikasiController@checkEmail');
Route::post('/check-email-for-register', 'AutentikasiController@checkEmail2');
Route::post('/check-email-for-verify', 'AutentikasiController@checkEmail3');
Route::post('/check-hp-for-register', 'AutentikasiController@checkNoHp');
Route::post('/check-hp-for-activate', 'AutentikasiController@checkNoHp2');
Route::post('/send-verification', 'AutentikasiController@sendVerif');
Route::post('/forgot-password', 'AutentikasiController@forgotPassword');
Route::namespace('User')->group(function(){
	Route::post('/login', 'LoginController@login');
});
Route::post('/daftar', 'AutentikasiController@register');
Route::put('/user-verify/{id}', 'AutentikasiController@verify');

Route::group(['middleware' => ['user_auth']], function(){

	// user aktif
	Route::get('/user-aktif', 'UserController@getUserAktif');

	# AREA API 
	Route::get('/cities/{province}', 'AreaController@cities');
	Route::get('/regions/{city}', 'AreaController@regions');
	Route::get('/villages/{region}', 'AreaController@villages');

	Route::put('/user-profile/update', 'UserController@update');
	Route::group(['middleware' => ['user']], function(){

		Route::group(['prefix' => 'user-profile'], function(){
			Route::put('/update-password', 'UserController@updatePass');
			Route::put('/update-email', 'UserController@updateEmail');
			Route::put('/update-bank', 'UserController@updateBank');
			Route::put('/update-bio', 'UserController@updateBio');
			Route::namespace('User')->group(function(){
				Route::put('/update-phone-number', 'PhoneNumberController@updatePhoneNumber');
			});
			Route::put('/update-avatar', 'UserController@updateAvatar');
			Route::put('/update-biodata', 'UserController@updateBiodata');
			Route::put('/update/{biography}', 'UserController@updateBiography');
		});

		# DATA HARUS KOMPLIT
		// Route::group(['middleware' => ['complete_bio', 'complete_biodata', 'complete_biography', 'complete_bank_account']], function(){

			# KONTEN
		Route::group(['prefix' => 'my-contents'], function(){
			Route::post('/store', 'ContentController@store');
			Route::put('/update/{content}', 'ContentController@update');
			Route::delete('/delete/{content}', 'ContentController@delete')->name('my_content.delete');
		});

			# MY FEEDBACKS
		Route::group(['prefix' => 'my-feedbacks'], function(){
			Route::post('/store', 'FeedbackController@store');
			Route::put('/update/{feedback}', 'FeedbackController@update');
			Route::delete('/delete/{feedback}', 'FeedbackController@delete')->name('my_feedbacks.delete');
		});

			# DEPOSIT TRANSACTIONS
		Route::group(['prefix' => 'transaksi-saldo'], function(){
			Route::post('/pesan-saldo', 'DepositTransactionController@pesanSaldo');
			Route::post('/bayar-saldo', 'DepositTransactionController@bayarSaldo');
			Route::delete('/{depo}', 'DepositTransactionController@delete')->name('deposit.delete');
		});

			# POINTS
		Route::post('points/claim', 'PointController@claim');

			# UPGRADE MEMBER
		Route::put('/upgrade-member', 'UserController@upgrade');

			# AMBIL SALDO
		Route::put('/claim-deposit', 'DepositTransactionController@claim');

			# TANGGAPAN USER
			//konten
		Route::post('/comment/{content}', 'CommentController@post');
		Route::put('/comment/update/{comment}', 'CommentController@update');
			// masukan
		Route::post('/feedback-comment/{feedback}', 'CommentController@postFeedback');
		Route::put('/feedback-comment/update/{comment}', 'CommentController@updateFeedback');
		// });
	});
});

# UPGRADE MEMBER SETTING
Route::get('/upgrade-member-setting', 'Admin\SettingController@upMember');

# LOGOUT
Route::middleware('admin')->group(function(){
Route::get('/data-diri', 'DataDiriController@get');
	Route::put('/data-diri/verifikasi-ktp/{user_bio}', 'DataDiriController@verifikasiKtp');
	Route::put('/data-diri/tolak-ktp/{user_bio}', 'DataDiriController@tolakKtp');
	Route::post('/logout', 'Auth\LoginController@logout');
});

// profil saya
Route::get('/biodata/user-aktif', 'BiodataController@getUserAktif');
Route::put('/biodata/user-aktif', 'BiodataController@update');
Route::get('/biodata/skill', 'BiodataController@getSkill');
Route::get('/biodata/passion', 'BiodataController@getPassion');
Route::get('/biodata/hobi', 'BiodataController@getHobi');
Route::get('/biodata/bahasa', 'BiodataController@getBahasa');
Route::get('/biodata/karakter', 'BiodataController@getKarakter');