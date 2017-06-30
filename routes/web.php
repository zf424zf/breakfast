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

Route::get('/', 'IndexController@index');
Route::get('metro', 'MetroController@index');

Route::group(['prefix'     => 'cart',], function () {
    Route::get('{placeId?}', 'CartController@index')->where('placeId', '\+?[1-9]\d*');
    Route::post('add', 'CartController@add');
    Route::get('list', 'CartController@lists');
});

Route::group(['prefix'     => 'product',], function () {
    Route::get('{id?}', 'ProductController@show')->where('id', '\+?[1-9]\d*');
});

Route::group(['prefix'     => 'order',], function () {
    Route::get('/', 'OrderController@index');
    Route::get('confirm', 'OrderController@confirm');
    Route::get('pay', 'OrderController@pay');
    Route::any('notify', 'OrderController@notify');
    Route::post('pay', 'OrderController@postPay');
    Route::post('create', 'OrderController@create');
    Route::post('cancel', 'OrderController@cancel');
    Route::get('result', 'OrderController@result');
});

Route::get('station/{id}', 'MetroController@station')->where('id', '\+?[1-9]\d*');
Route::get('post/{id}', 'PostController@show')->where('id', '\+?[1-9]\d*');


Route::get('test', 'TestController@index');