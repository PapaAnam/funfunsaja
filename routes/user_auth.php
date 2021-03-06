<?php 

Route::group(['middleware' => ['must_logout']], function(){

	Route::middleware('buat_aktivitas')->group(function(){

		Route::post('/logout', 'AutentikasiController@logout')->name('user_logout');
		Route::get('/user-profile/edit', 'UserController@edit');
		Route::get('/all-user', 'ListUserController@index');

		Route::group(['middleware' => ['user']], function(){

			Route::group(['prefix' => 'user-profile'], function(){
				Route::get('/', 'UserController@index');
				Route::get('/other', 'UserController@other');

				# REKENING
				Route::namespace('User')->group(function(){
					Route::get('/bank-account', 'BankAccountController@index');
					Route::get('/bank-account/edit', 'BankAccountController@edit');
					Route::get('/edit-phone-number', 'PhoneNumberController@index');
				});
				Route::get('/edit-email', 'UserController@editEmail');
				Route::get('/edit-password', 'UserController@editPass');
			});

			# CONTENTS
			Route::prefix('contents')->group(function(){
				Route::get('/{ck}/{content}/confirm', 'ContentController@alert')->name('contents.confirm');
				Route::post('/buy', 'ContentController@buy')->name('contents.buy');
			});

			# USER PROFILE
			Route::group(['prefix' => 'user-profile'], function(){
				Route::get('/cv/print', 'UserController@printCV')->name('cv.print');
			});

			# UPGRADE MEMBER
			Route::get('/upgrade-member', 'UserController@upgradeForm')->name('upgrade_member');

			# MEMBER STATUS
			Route::get('/member-status', 'UserController@memberStatus')->name('member_status');

			# NOTIFICATIONS
			Route::get('/my-notifications', 'NotificationController@index')->name('my_notif');

			# MY ACTIVITIES
			Route::get('/my-activities', 'ActivityController@index')->name('my_activities');

			# MY POINTS
			Route::get('/my-points', 'PointController@index')->name('my_points');

			# COMMENT
			Route::get('/comments/{content}', 'CommentController@index')->name('comment');
			Route::get('/comments/{content}/{comment}', 'CommentController@setBest')->name('comment.best');

			# FEEDBACK COMMENTS
			Route::get('/feedback-comments/{feedback}', 'CommentController@onFeedback')->name('feedback_comment');
			Route::get('/feedback-comments/{feedback}/{comment}', 'CommentController@setBestFeedback')->name('feedback_comment.best');

			# MY COMMENTS ON CONTENTS
			Route::get('/my-comments/content', 'CommentController@mineInContent')->name('comments.content');
			Route::get('/my-comments/content/edit/{content}/{comment}', 'CommentController@mineInContentEdit')->name('comments.content.edit');

			# MY COMMENTS ON FEEDBACKS
			Route::get('/my-comments/feedback', 'CommentController@mineInFeedback')->name('comments.feedback');
			Route::get('/my-comments/feedback/edit/{feedback}/{comment}', 'CommentController@mineInFeedbackEdit')->name('comments.feedback.edit');

			# KONTEN
			Route::group(['prefix' => 'my-contents'], function(){
				Route::get('/', 'ContentController@index')->name('my_content');
				Route::get('/create', 'ContentController@create')->name('create_content');
				Route::get('/edit/{content}', 'ContentController@edit')->name('my_content.edit');
			});

			# MY FEEDBACKS
			Route::group(['prefix' => 'my-feedbacks'], function(){
				Route::get('/', 'FeedbackController@myFb')->name('my_feedbacks');
				Route::get('/create', 'FeedbackController@create')->name('create_feedbacks');
				Route::post('/store', 'FeedbackController@store');
				Route::get('/edit/{feedback}', 'FeedbackController@edit')->name('my_feedbacks.edit');
				Route::put('/update/{id}', 'FeedbackController@update');
			});

			# SALDO USER
			Route::group(['prefix' => 'transaksi-saldo'], function(){
				Route::get('/', 'DepositTransactionController@index')->name('transaksi-saldo');
				Route::get('/claim', 'DepositTransactionController@claimView')->name('claim_deposit');
				Route::get('/create', 'DepositTransactionController@create');
				Route::get('/edit/{id}', 'DepositTransactionController@edit');
				Route::put('/update/{id}', 'DepositTransactionController@update');
				Route::delete('/delete/{id}', 'DepositTransactionController@delete');
			});

			# SET KOMENTAR TERBAIK
			Route::post('/comments/set-best/{comment}/{content}', 'CommentController@setTerbaik');

			// Profil saya
			Route::prefix('profil-saya')->group(function(){
				Route::prefix('biodata')->group(function(){
					Route::get('/ubah', 'BiodataController@edit');
				});
			});

		});
	});
});