<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'shop'], function () {
    Route::post('login', 'Api\V1\ShopAuthController@login');
    Route::group(['middleware' => 'auth:api','prefix'=>'product'], function () {
        Route::post('create', 'Api\V1\ProductController@create');
        Route::get('list', 'Api\V1\ProductController@list');
        Route::post('delete', 'Api\V1\ProductController@delete');
        Route::post('update', 'Api\V1\ProductController@update');

    });

});
