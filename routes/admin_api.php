<?php 

Route::middleware('admin_must_logout')->group(function(){

	Route::middleware('admin_buat_aktivitas')->group(function(){

		# ADMIN PROFILE
		Route::get('/admin-auth', 'AdminController@profile');

		Route::get('/menu', 'MenuController@api');

		# DASHBOARD
		Route::get('/dashboard', 'DashboardController@api');

		# FEEDBACK KINDS
		Route::group(['prefix' => 'feedback-kinds'], function(){
			Route::get('/', 'FeedbackKindController@api');
			Route::post('/store', 'FeedbackKindController@store');
			Route::put('/update/{id}', 'FeedbackKindController@update');
			Route::delete('/delete/{id}', 'FeedbackKindController@delete');
		});

		# PAGE KINDS
		Route::group(['prefix' => 'page-kinds'], function(){
			Route::get('/', 'PageKindController@api');
			Route::post('/store', 'PageKindController@store');
			Route::put('/update/{id}', 'PageKindController@update');
			Route::delete('/delete/{id}', 'PageKindController@delete');
		});

		# CATEGORIES
		Route::group(['prefix' => 'categories'], function(){
			Route::get('/', 'KategoriController@api');
			Route::post('/store', 'KategoriController@store');
			Route::put('/update/{id}', 'KategoriController@update');
			Route::delete('/delete/{id}', 'KategoriController@delete');
		});

		# CONTENT KINDS
		Route::group(['prefix' => 'content-kinds'], function(){
			Route::get('/', 'ContentKindController@api');
			Route::post('/store', 'ContentKindController@store');
			Route::put('/update/{id}', 'ContentKindController@update');
			Route::delete('/delete/{id}', 'ContentKindController@delete');
		});

		# BANK ACCOUNTS
		Route::group(['prefix' => 'bank-accounts'], function(){
			Route::get('/', 'BankAccountController@api');
			Route::post('/store', 'BankAccountController@store');
			Route::put('/update/{id}', 'BankAccountController@update');
			Route::delete('/delete/{id}', 'BankAccountController@delete');
		});

		# SLIDERS
		Route::group(['prefix' => 'sliders'], function(){
			Route::get('/', 'SliderController@api');
			Route::post('/store', 'SliderController@store');
			Route::put('/update/{id}', 'SliderController@update');
			Route::delete('/delete/{id}', 'SliderController@delete');
		});

		# PAGES
		Route::group(['prefix' => 'pages'], function(){
			Route::get('/today', 'PageController@today');
			Route::get('/{year}/{month}', 'PageController@filter');
			Route::get('/{id}', 'PageController@single');
			Route::post('/store', 'PageController@store');
			Route::put('/update/{id}', 'PageController@update');
			Route::delete('/delete/{url}', 'PageController@delete');
		});

		# TAGS
		Route::get('/tags', 'TagController@index');

		# USERS
		Route::group(['prefix' => 'users'], function(){
			Route::get('/', 'UserController@api');
			Route::put('/update-status/{id}', 'UserController@update');
			Route::post('/store', 'UserController@store');
			Route::delete('/{admin}', 'UserController@delete');
		});

		# DEPOSIT
		Route::group(['prefix' => 'deposit'], function(){
			Route::get('/today', 'DepositController@today');
			Route::get('/{year}/{month}', 'DepositController@filter');
			Route::put('/update-status/{id}', 'DepositController@update');
			Route::get('/detail/{id}', 'DepositController@detail');
			Route::put('/verif/{id}', 'DepositController@verif');
		});

		# PENGATURAN MENU
		Route::group(['prefix' => 'menu-setting'], function(){
			Route::get('/font-type', 'MenuController@fontType');
			Route::get('/{all?}', 'MenuController@api');
			Route::post('/store', 'MenuController@store');
			Route::put('/update/{id}', 'MenuController@update');
			Route::delete('/delete/{id}', 'MenuController@delete');
			Route::post('/sub-menu/store/{id}', 'MenuController@storeSubMenu');
			Route::put('/sub-menu/update/{id}', 'MenuController@updateSubMenu');
			Route::put('/geser/{id}/{arah}/{prim?}', 'MenuController@geser');
			Route::put('/update-font-type', 'MenuController@changeFont');
		});

		# PENGATURAN HOME / BERANDA
		Route::group(['prefix' => 'home-setting'], function(){
			Route::get('/', 'HomeController@setting');
			Route::put('/update-why-us', 'HomeController@updateWhyUs');
			Route::put('/update-tentang', 'HomeController@updateTentang');
		});

		# PENGATURAN WEB
		Route::group(['prefix' => 'web-setting'], function(){
			Route::get('/', 'WebSettingController@api');
			Route::put('/update', 'WebSettingController@update');
		});

		# PENGATURAN POINT
		Route::get('point-setting', 'SettingController@point');
		Route::put('point-setting', 'SettingController@updatePoint');

		# PEROLEHAN POIN
		Route::prefix('points')->group(function(){
			Route::get('/today', 'PointController@today');
			Route::get('/{year}/{month}', 'PointController@filter');
		});

		# MODERASI KONTEN
		Route::prefix('contents')->group(function(){
			Route::get('/today', 'ContentController@today');
			Route::get('/{year}/{month}', 'ContentController@filter');
			Route::put('moderate/{id}', 'ModerateController@update');
		});

		# AKTIVITAS MODERASI
		Route::prefix('moderate-activities')->group(function(){
			Route::get('/today', 'ModerateActivityController@today');
			Route::get('/{year}/{month}', 'ModerateActivityController@filter');
		});

		Route::prefix('activities')->group(function(){
			Route::get('/today', 'ActivityController@today');
			Route::get('/{year}/{month}', 'ActivityController@filter');
		});

		# UPGRADE MEMBER SETTING
		Route::put('/upgrade-member-setting', 'SettingController@updateUpMember');

		# DEPOSIT CLAIMS
		Route::prefix('depo-claims')->group(function(){
			Route::get('/today', 'DepositClaimController@today');
			Route::get('/{year}/{month}', 'DepositClaimController@filter');
		});

		// ambil saldo
		Route::put('/ambil-saldo/verifikasi/{depo}', 'DepositController@claimVerify');

		// klaim saldo
		Route::get('/klaim-saldo', 'KlaimSaldoController@index');

		// upgrade member
		Route::get('/upgrade-member', 'UpgradeMemberController@index');

		// fee konten
		Route::get('/fee-konten', 'FeeKontenController@index');

		// view konten
		Route::get('/view-konten', 'ViewKontenController@index');
		

		# TANGGAPAN
		Route::prefix('comments')->group(function(){
			Route::get('/today', 'CommentController@index');
			Route::get('/{year}/{month}', 'CommentController@filterTime');
			Route::put('/publish/{comment}', 'CommentController@publish');
			Route::put('/reject/{comment}', 'CommentController@reject');
		});

		# TANGGAPAN MASUKAN
		Route::prefix('feedback-comments')->group(function(){
			Route::get('/today', 'FeedbackCommentController@index');
			Route::get('/{year}/{month}', 'FeedbackCommentController@filterTime');
			Route::put('/publish/{comment}', 'FeedbackCommentController@publish');
			Route::put('/reject/{comment}', 'FeedbackCommentController@reject');
		});

		# SETTING 
		Route::prefix('setting')->group(function(){
			Route::get('/sms', 'SmsSettingController@index');
			Route::put('/sms/update', 'SmsSettingController@update');
		});

		# MODERASI MASUKAN 
		Route::prefix('moderasi-masukan')->group(function(){
			Route::get('/', 'ModerasiMasukanController@index');
		});

		# AKTIVITAS SALDO
		Route::get('/aktivitas-saldo', 'AktivitasSaldoController@index');

		# NOTIFIKASI
		Route::get('/notifikasi', 'NotifikasiController@index');

	});

});