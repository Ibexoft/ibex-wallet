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
    return view('welcome');
});

Route::get('accounts', 'AccountsController@index');
Route::get('accounts/create', 'AccountsController@create');
Route::get('accounts/{account}', 'AccountsController@show');
Route::post('accounts', 'AccountsController@store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
