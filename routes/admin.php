<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('admin')->user();

    //dd($users);

    return view('admin.home');
})->name('home');



Route::group(['prefix' => 'products'], function () {
    Route::get('/index', 'AdminAuth\ProductsController@index')->name('products.index');
    Route::get('/create', 'AdminAuth\ProductsController@create')->name('products.create');
    Route::post('/store', 'AdminAuth\ProductsController@store')->name('products.store');
    Route::get('/edit/{id}', 'AdminAuth\ProductsController@edit')->name('products.edit');
    Route::post('/update', 'AdminAuth\ProductsController@update')->name('products.update');
    Route::post('/delete', 'AdminAuth\ProductsController@delete')->name('products.delete');
    Route::post('/deleteall', 'AdminAuth\ProductsController@deleteall')->name('products.deleteall');
    Route::get('exportData', 'AdminAuth\ProductsController@exportData')->name('products.exportData');
    Route::get('importData', 'AdminAuth\ProductsController@importData')->name('products.importData');
    Route::post('import', 'AdminAuth\ProductsController@import')->name('products.import');
    

});



Route::group(['prefix' => 'shop'], function () {
    Route::get('/index', 'AdminAuth\ShopController@index')->name('shop.index');
    Route::get('/create', 'AdminAuth\ShopController@create')->name('shop.create');
    Route::post('/store', 'AdminAuth\ShopController@store')->name('shop.store');
    Route::get('/edit/{id}', 'AdminAuth\ShopController@edit')->name('shop.edit');
    Route::post('/update', 'AdminAuth\ShopController@update')->name('shop.update');
    Route::post('/delete', 'AdminAuth\ShopController@delete')->name('shop.delete');
    Route::post('/deleteall', 'AdminAuth\ShopController@deleteall')->name('shop.deleteall');
    Route::any('/unassigned', 'AdminAuth\ShopController@unassigned')->name('shop.unassigned');
    Route::any('/assign', 'AdminAuth\ShopController@assign')->name('shop.assign');

});



Route::get('export', 'AdminAuth\MyController@export')->name('export');
Route::get('importExportView', 'AdminAuth\MyController@importExportView');
Route::post('import', 'AdminAuth\MyController@import')->name('import');


