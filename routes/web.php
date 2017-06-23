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

Route::group(['prefix'     => 'cart',], function ($router) {
    Route::get('{placeId?}', 'CartController@index')->where('placeId', '\+?[1-9]\d*');
    Route::post('add', 'CartController@add');
    Route::get('list', 'CartController@lists');
});
Route::get('order', 'OrderController@index');
Route::get('station/{id}', 'MetroController@station')->where('id', '\+?[1-9]\d*');
Route::get('post/{id}', 'PostController@show')->where('id', '\+?[1-9]\d*');