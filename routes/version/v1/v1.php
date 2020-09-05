<?php

use Illuminate\Support\Facades\Route;

Route::post('/auth/login', 'Api\v1\Auth\LoginController@login')->name('login');
Route::post('/auth/logout', 'Api\v1\Auth\LogoutController@logout');
Route::post('/auth/register', 'Api\v1\Auth\RegisterController@register');

Route::get('/my/profile', 'Api\v1\My\ProfileController@get');
Route::post('/my/profile', 'Api\v1\My\ProfileController@update');
Route::post('/my/password', 'Api\v1\My\PasswordController@update');

Route::get('/records', 'Api\v1\Record\RecordsController@get');
Route::get('/record/categories', 'Api\v1\Record\CategoryController@get');
Route::put('/record/category', 'Api\v1\Record\CategoryController@put');
Route::delete('/record/category/{categoryId}', 'Api\v1\Record\CategoryController@delete')->where('categoryId', '[0-9]+');

Route::get('/record/category/{categoryId}/subcategories', 'Api\v1\Record\SubCategoryController@get')->where('categoryId', '[0-9]+');
Route::put('/record/category/{categoryId}/subcategory', 'Api\v1\Record\SubCategoryController@put')->where('categoryId', '[0-9]+');
Route::delete('/record/subcategory/{subCategoryId}', 'Api\v1\Record\SubCategoryController@delete')->where('subCategoryId', '[0-9]+');