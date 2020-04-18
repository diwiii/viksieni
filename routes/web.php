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
// App config, PLEASE DISABLE ON PRODUCTION;
Route::get('/site/edit/{site}', 'SiteController@edit')->name('site.edit')->middleware('auth');
Route::put('/site/{site}', 'SiteController@update')->name('site.update')->middleware('auth');

Route::post('/product', 'ProductController@store')->middleware('auth');
Route::get('/product/create', 'ProductController@create')->name('product.create')->middleware('auth');

Route::get('/product/edit/{product}', 'ProductController@edit')->name('product.edit')->middleware('auth');
Route::put('/product/{product}', 'ProductController@update')->name('product.update')->middleware('auth');

//Category
Route::get('/category', 'CategoryController@index')->name('category.index');
Route::post('/category', 'CategoryController@store')->name('category.store')->middleware('auth');
Route::get('/category/create', 'CategoryController@create')->name('category.create')->middleware('auth');
Route::get('/category/edit/{category}', 'CategoryController@edit')->name('category.edit')->middleware('auth');
Route::get('/category/{category}', 'CategoryController@show')->name('category.show');
Route::put('/category/{category}', 'CategoryController@update')->name('category.update')->middleware('auth');
Route::delete('/category/{category}', 'CategoryController@destroy')->name('category.destroy')->middleware('auth');
//Section
Route::get('/section', 'SectionController@index')->name('section.index');
Route::post('/section', 'SectionController@store')->name('section.store')->middleware('auth');
Route::get('/section/create', 'SectionController@create')->name('section.create')->middleware('auth');
Route::get('/section/edit/{section}', 'SectionController@edit')->name('section.edit')->middleware('auth');
Route::get('/section/{section}', 'SectionController@show')->name('section.show');
Route::put('/section/{section}', 'SectionController@update')->name('section.update')->middleware('auth');
Route::delete('/section/{section}', 'SectionController@destroy')->name('section.destroy')->middleware('auth');

Route::delete('/product/{product}', 'ProductController@destroy')->name('product.destroy')->middleware('auth');


Route::get('/{product}', 'ProductController@show')->name('product.show');
