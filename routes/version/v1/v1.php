<?php

use Illuminate\Support\Facades\Route;

Route::post('/auth/login', 'Api\v1\Auth\LoginController@login')->name('login');
Route::post('/auth/logout', 'Api\v1\Auth\LogoutController@logout');
Route::post('/auth/register', 'Api\v1\Auth\RegisterController@register');

Route::get('/my/profile', 'Api\v1\My\ProfileController@get');
Route::post('/my/profile', 'Api\v1\My\ProfileController@update');
Route::post('/my/password', 'Api\v1\My\PasswordController@update');