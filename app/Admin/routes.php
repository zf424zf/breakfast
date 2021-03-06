<?php

use Illuminate\Routing\Router;

Admin::registerHelpersRoutes();

Route::group([
    'prefix'     => config('admin.prefix'),
    'namespace'  => Admin::controllerNamespace(),
    'middleware' => ['web', 'admin'],
], function (Router $router) {
    $router->get('/', 'HomeController@index');
    $router->resource('metro', 'MetroController');
    $router->resource('station_sort', 'StationSortController');
    $router->resource('place_sort', 'PlaceSortController');
    $router->resource('station', 'StationController');
    $router->resource('place', 'PlaceController');
    $router->resource('products', 'ProductsController');
    $router->resource('stock', 'StockController');
    $router->resource('pickuptime', 'PickuptimeController');
    $router->resource('category', 'CategoryController');
    $router->resource('post', 'PostController');
    $router->resource('setting', 'SettingController');
    $router->resource('users', 'UsersController');
    $router->resource('order', 'OrderController');
});
