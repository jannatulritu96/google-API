<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('dashboard','DashboardController@index')->name('dashboard');
Route::get('password-change', 'DashboardController@showResetForm')->name('password.change');
Route::post('password-update', 'DashboardController@updatepassword')->name('update.password');

Route::get('/password-reset', 'Auth\ForgotPasswordController@updatepass')->name('reset.password');

// product Routes
Route::get('product','ProductController@index')->name('product.index');
Route::get('product/create','ProductController@create')->name('product.create');
Route::post('product/store','ProductController@store')->name('product.store');
Route::get('product/show/{id}','productController@show')->name('product.show');
Route::get('product/edit/{id}','ProductController@edit')->name('product.edit');
Route::PUT('product/update/{id}','ProductController@update')->name('product.update');
Route::POST('product/destroy/{id}','ProductController@destroy')->name('product.destroy');

// Product image Routes
Route::get('product_images','product_imagesController@index')->name('product_images.index');
Route::get('product_images/create','product_imagesController@create')->name('product_images.create');
Route::post('product_images/store','product_imagesController@store')->name('product_images.store');
Route::get('product_images/show/{id}','product_imagesController@show')->name('product_images.show');
Route::get('product_images/edit/{id}','product_imagesController@edit')->name('product_images.edit');
Route::PUT('product_images/update/{id}','product_imagesController@update')->name('product_images.update');
Route::POST('product_images/destroy/{id}','product_imagesController@destroy')->name('product_images.destroy');

// category Routes
Route::get('category','CategoryController@index')->name('category.index');
Route::get('category/create','CategoryController@create')->name('category.create');
Route::post('category/store','CategoryController@store')->name('category.store');
Route::get('category/show/{id}','CategoryController@show')->name('category.show');
Route::get('category/edit/{id}','CategoryController@edit')->name('category.edit');
Route::PUT('category/update/{id}','CategoryController@update')->name('category.update');
Route::POST('category/destroy/{id}','CategoryController@destroy')->name('category.destroy');
