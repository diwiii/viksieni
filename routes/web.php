<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('index');
// });

/**
 * Authentication routes
 * Disabled routes: register, reset, confirm
 */
Auth::routes([
    'register' => false,
    'reset' => false,
    'confirm' => false
    ]);

// Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout'); //Kā tas strādā?
Route::get('/home', 'HomeController@index')->name('home');

// App root
Route::get('/', 'SiteController@index')->name('root');

Route::post('/product', 'ProductController@store')->middleware('auth');
Route::get('/product/create', 'ProductController@create')->name('product.create')->middleware('auth');

Route::get('/product/edit/{product}', 'ProductController@edit')->name('product.edit')->middleware('auth');
Route::put('/product/{product}', 'ProductController@update')->name('product.update')->middleware('auth');

Route::get('/category', 'CategoryController@index')->name('category.index');
Route::post('/category', 'CategoryController@store')->name('category.store')->middleware('auth');
Route::get('/category/create', 'CategoryController@create')->name('category.create')->middleware('auth');
Route::put('/category/{category}', 'CategoryController@update')->name('category.update')->middleware('auth');
Route::get('/category/{category}/edit', 'CategoryController@edit')->name('category.edit')->middleware('auth');

Route::get('/{product}', 'ProductController@show')->name('product.show');
