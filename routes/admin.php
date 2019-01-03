<?php 

# SPA
Route::middleware('must_logout')->group(function(){
	
	Route::view('/admin-menu/{sub_menu?}/{sub_sub?}/{sub_sub_sub?}', 'admin')->name('admin_menu');
	Route::view('/admin-menu/moderasi-masukan', 'admin');

});

# CONTENTS
Route::get('/contents-preview/{content}', 'Admin\ModerateController@preview')->middleware('must_logout');

# ADMIN LOGOUT
Route::post('/administrator/api/logout', 'Auth\LoginController@logout');

Route::get('/admin/moderasi-masukan/{url}/preview', 'Admin\ModerasiMasukanController@preview')->name('moderasi-masukan.preview');
Route::get('/admin/moderasi-masukan/{id}/tolak', 'Admin\ModerasiMasukanController@tolak')->name('moderasi-masukan.tolak');
Route::get('/admin/moderasi-masukan/{id}/terima', 'Admin\ModerasiMasukanController@terima')->name('moderasi-masukan.terima');

// MELIHAT CV MEMBER
Route::get('/cv/{username}', 'Admin\CVMemberController@index');