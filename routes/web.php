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

Route::any('/init', "TelegramController@init");

Route::get('/checkDup', "TelegramController@checkDup");

Route::any('/addUser', "TelegramController@addUser");

Route::get('/test', "TelegramController@test");
