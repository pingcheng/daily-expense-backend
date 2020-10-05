<?php

use App\Http\Controllers\Api\v1\Auth\LoginController;
use App\Http\Controllers\Api\v1\Auth\LogoutController;
use App\Http\Controllers\Api\v1\Auth\RegisterController;
use App\Http\Controllers\Api\v1\My\PasswordController;
use App\Http\Controllers\Api\v1\My\ProfileController;
use App\Http\Controllers\Api\v1\Record\CategoryController;
use App\Http\Controllers\Api\v1\Record\RecordsController;
use App\Http\Controllers\Api\v1\Record\SubCategoryController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [LoginController::class, 'login'])->name('login');
Route::post('/auth/logout', [LogoutController::class, 'logout']);
Route::post('/auth/register', [RegisterController::class, 'register']);

Route::get('/my/profile', [ProfileController::class, 'get']);
Route::post('/my/profile', [ProfileController::class, 'update']);
Route::post('/my/password', [PasswordController::class, 'update']);

Route::get('/records', [RecordsController::class, 'get']);
Route::get('/record/categories', [CategoryController::class, 'get']);
Route::put('/record/category', [CategoryController::class, 'put']);
Route::delete('/record/category/{categoryId}', [CategoryController::class, 'delete'])->where('categoryId', '[0-9]+');
Route::patch('/record/category/{categoryId}', [CategoryController::class, 'patch'])->where('categoryId', '[0-9]+');

Route::get('/record/category/{categoryId}/subcategories', [SubCategoryController::class,'get'])->where('categoryId', '[0-9]+');
Route::put('/record/category/{categoryId}/subcategory', [SubCategoryController::class,'put'])->where('categoryId', '[0-9]+');
Route::patch('/record/subcategory/{subCategoryId}', [SubCategoryController::class,'patch'])->where('subCategoryId', '[0-9]+');
Route::delete('/record/subcategory/{subCategoryId}', [SubCategoryController::class,'delete'])->where('subCategoryId', '[0-9]+');