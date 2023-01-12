<?php

Route::get('/home', function () {
    $users[] = Auth::user();
    $users[] = Auth::guard()->user();
    $users[] = Auth::guard('shopss')->user();

    //dd($users);

    return view('shopss.home');
})->name('home');

Route::group(['prefix' => 'shop'], function () {
    Route::get('/index', 'ShopssAuth\ShopController@index')->name('shop.index');
    Route::get('/create', 'ShopssAuth\ShopController@create')->name('shop.create');
    Route::post('/store', 'ShopssAuth\ShopController@store')->name('shop.store');
    Route::get('/edit/{id}', 'ShopssAuth\ShopController@edit')->name('shop.edit');
    Route::post('/update', 'ShopssAuth\ShopController@update')->name('shop.update');
    Route::post('/delete', 'ShopssAuth\ShopController@delete')->name('shop.delete');
    Route::post('/deleteall', 'ShopssAuth\ShopController@deleteall')->name('shop.deleteall');
    Route::any('/unassigned', 'ShopssAuth\ShopController@unassigned')->name('shop.unassigned');
    Route::any('/assign', 'ShopssAuth\ShopController@assign')->name('shop.assign');
});
