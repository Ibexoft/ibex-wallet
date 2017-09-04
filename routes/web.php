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

Route::get('/', 'TransactionController@index');

Route::get('accounts', 'AccountsController@index');
Route::get('accounts/create', 'AccountsController@create');
Route::get('accounts/{account}', 'AccountsController@show');
Route::post('accounts', 'AccountsController@store');

Route::get('tags', 'TagController@index');
Route::get('tags/create', 'TagController@create');
Route::get('tags/{tag}', 'TagController@show');
Route::post('tags', 'TagController@store');

Route::get('transactions', 'TransactionController@index');
Route::get('transactions/create', 'TransactionController@create');
Route::get('transactions/{transaction}', 'TransactionController@show');
Route::post('transactions', 'TransactionController@store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
