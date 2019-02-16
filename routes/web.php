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
Route::get('/', 'HomeController@index');


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/login','HomeController@getLogin')->name('login');
Route::get('/search','HomeController@searchItem');
Route::get('/category/{category}','HomeController@getCategory');
Route::get('/brand/{brand}','HomeController@getBrands');
Route::get('/contact_us','HomeController@getContact');

Route::post('/login','UsersController@postLogin')->name('postLogin');
Route::post('/register','UsersController@postRegister')->name('register');

Route::group(['middleware'=>['auth']],function(){
    Route::post('/logout','UsersController@logout')->name('logout');
    Route::post('/addToCart/{id}','ItemsController@addToCart')->name('addToCart');
    Route::get('/cart','HomeController@Cart')->name('cart');
    Route::get('/updateCart/{type}/{id}','ItemsController@updateCart')->name('updateCart');
    Route::group(['prefix'=>'account'],function(){
        Route::get('/','UsersController@getAccount')->name('account');
        Route::post('/addAddress','UsersController@addAddress')->name('add_address');
        Route::post('/updateUser','UsersController@updateUser')->name('updateUser');
        Route::get('/deleteAddress/{id}','UsersController@deleteAddress')->name('deleteAddress');
    });
    Route::get('/checkout','HomeController@checkout')->name('checkout');
    Route::post('/placeOrder','HomeController@placeOrder')->name('placeOrder');
    Route::get('/orders','HomeController@getOrders')->name('orders');
    Route::get('/cancel/{id}','HomeController@cancelOrder')->name('cancel');
});
Route::get('/admin/changeStatus/{status}/{id}','HomeController@changeStatus')->name('changeStatus');
Route::get('/admin/orders/view/{id}','HomeController@viewOrder')->name('viewOrder');