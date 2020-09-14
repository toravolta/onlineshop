<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', 'ProductController@display')->name("product.display");
Route::get('/detail/{id}', 'ProductController@detailProduct')->name("product.detail");

Auth::routes(['verify' => true]);
Route::group(['middleware' => ['auth', 'verified']], function () {

    Route::get('/home', 'HomeController@index')->name('home')->middleware('cekstatus');
    Route::resource('product', 'ProductController')->middleware('cekstatus');

    Route::post('/cart', 'CartController@store')->name("cart.store");
    Route::get('/cart/{id}', 'CartController@detail')->name("cart.detail");
    Route::delete('/cart/{id}', 'CartController@delete')->name("cart.delete");

    Route::resource('order', 'OrderController');
    Route::put('/order/reupdate/{id}', 'OrderController@reupdate')->name("order.reupdate");
});
