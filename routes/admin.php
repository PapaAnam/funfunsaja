<?php 

# SPA
Route::view('/admin-menu/{sub_menu?}/{sub_sub?}/{sub_sub_sub?}', 'admin')->name('admin_menu')->middleware('must_logout');

# CONTENTS
Route::get('/contents-preview/{content}', 'Admin\ModerateController@preview')->middleware('must_logout');

# ADMIN LOGOUT
Route::post('/administrator/api/logout', 'Auth\LoginController@logout');
