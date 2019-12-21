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
Route::get('password-change', 'HomeController@showResetForm')->name('password.change');
Route::post('password-update', 'HomeController@updatepassword')->name('update.password');

Route::get('/password-reset', 'Auth\ForgotPasswordController@updatepass')->name('reset.password');

// product Routes
Route::get('product','productController@index')->name('product.index');
Route::get('product/create','productController@create')->name('product.create');
Route::post('product/store','productController@store')->name('product.store');
//Route::get('product/show/{id}','productController@show')->name('product.show');
Route::get('product/edit/{id}','productController@edit')->name('product.edit');git commit -m "first commit"
Route::PUT('product/update/{id}','productController@update')->name('product.update');
Route::POST('product/destroy/{id}','productController@destroy')->name('product.destroy');

// category Routes
Route::get('category','categoryController@index')->name('category.index');
Route::get('category/create','categoryController@create')->name('category.create');
Route::post('category/store','categoryController@store')->name('category.store');
Route::get('category/show/{id}','categoryController@show')->name('category.show');
Route::get('category/edit/{id}','categoryController@edit')->name('category.edit');
Route::PUT('category/update/{id}','categoryController@update')->name('category.update');
Route::POST('category/destroy/{id}','categoryController@destroy')->name('category.destroy');
