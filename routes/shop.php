<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('shop')->user();

    //dd($users);

    return view('shop.home');
})->name('shop.home');

Route::get('/profile', 'ShopAuth\ShopController@profile')->name('profile');
Route::post('/update', 'ShopAuth\ShopController@update')->name('update');


Route::group(['prefix' => 'deliveryman'], function () {
    Route::get('/index', 'ShopAuth\DeliverymanController@index')->name('deliveryman.index');
    Route::get('/create', 'ShopAuth\DeliverymanController@create')->name('deliveryman.create');
    Route::post('/store', 'ShopAuth\DeliverymanController@store')->name('deliveryman.store');
    Route::get('/edit/{id}', 'ShopAuth\DeliverymanController@edit')->name('deliveryman.edit');
    Route::post('/update', 'ShopAuth\DeliverymanController@update')->name('deliveryman.update');
    Route::post('/delete', 'ShopAuth\DeliverymanController@delete')->name('deliveryman.delete');
    Route::post('/deleteall', 'ShopAuth\DeliverymanController@deleteall')->name('deliveryman.deleteall');
    Route::any('/unassigned', 'ShopAuth\DeliverymanController@unassigned')->name('deliveryman.unassigned');
    Route::any('/assign', 'ShopAuth\DeliverymanController@assign')->name('deliveryman.assign');

});

Route::group(['prefix' => 'category'], function () {
    Route::get('/index', 'ShopAuth\CategoryController@index')->name('category.index');
    Route::get('/create', 'ShopAuth\CategoryController@create')->name('category.create');
    Route::post('/store', 'ShopAuth\CategoryController@store')->name('category.store');
    Route::get('/edit/{id}', 'ShopAuth\CategoryController@edit')->name('category.edit');
    Route::post('/update', 'ShopAuth\CategoryController@update')->name('category.update');
    Route::post('/delete', 'ShopAuth\CategoryController@delete')->name('category.delete');
    Route::post('/deleteall', 'ShopAuth\CategoryController@deleteall')->name('category.deleteall');
    Route::any('/unassigned', 'ShopAuth\CategoryController@unassigned')->name('category.unassigned');
    Route::any('/assign', 'ShopAuth\CategoryController@assign')->name('category.assign');
});



Route::group(['prefix' => 'products'], function () {
    Route::get('/index', 'ShopAuth\ProductsController@index')->name('products.index');
    Route::get('/create', 'ShopAuth\ProductsController@create')->name('products.create');
    Route::post('/store', 'ShopAuth\ProductsController@store')->name('products.store');
    Route::get('/edit/{id}', 'ShopAuth\ProductsController@edit')->name('products.edit');
    Route::post('/update', 'ShopAuth\ProductsController@update')->name('products.update');
    Route::post('/delete', 'ShopAuth\ProductsController@delete')->name('products.delete');
    Route::post('/deleteall', 'ShopAuth\ProductsController@deleteall')->name('products.deleteall');
    Route::any('/unassigned', 'ShopAuth\ProductsController@unassigned')->name('products.unassigned');
    Route::any('/assign', 'ShopAuth\ProductsController@assign')->name('products.assign');
    Route::get('/add/stock/{id}', 'ShopAuth\InventoryController@inventory')->name('products.inventory');

});

Route::group(['prefix' => 'inventory'], function () {
    Route::post('/store', 'ShopAuth\InventoryController@store')->name('inventory.store');
    Route::post('/update', 'ShopAuth\InventoryController@update')->name('inventory.update');
    Route::delete('/delete', 'ShopAuth\InventoryController@delete')->name('inventory.delete');

});
