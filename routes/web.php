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

Route::get('/test/di', 'MailTestController@testDependency');
Route::get('/test/send', 'MailTestController@testSend');
Route::get('/test/get', 'MailTestController@testGet');

Route::get('/test/temp', 'MailTestController@testTemp');
