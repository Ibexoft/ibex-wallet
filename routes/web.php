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

Route::get('accounts', function () {
    $accounts = DB::table('accounts')->get();
    return view('accounts.index', compact('accounts'));
});

Route::get('accounts/{id}', function ($id) {
    $account = DB::table('accounts')->find($id);

    return view('accounts.show', compact('account'));
});
