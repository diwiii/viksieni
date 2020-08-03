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
Route::post('/omniva', 'OmnivaController@omnivaJSON')->name('omniva.locations')->middleware('auth');

// Omniva
Route::get('/omniva/pakomats', 'OmnivaController@index')->name('omniva.index');

// App root
Route::get('/', 'SiteController@index')->name('root');
// App config, PLEASE DISABLE ON PRODUCTION;
/////////////
Route::get('/site/edit/{site}', 'SiteController@edit')->name('site.edit')->middleware('auth');
Route::put('/site/{site}', 'SiteController@update')->name('site.update')->middleware('auth');
/////////////

// Product
Route::post('/product', 'ProductController@store')->middleware('auth');
Route::get('/product/create', 'ProductController@create')->name('product.create')->middleware('auth');
Route::get('/product/edit/{product}', 'ProductController@edit')->name('product.edit')->middleware('auth');
Route::put('/product/{product}', 'ProductController@update')->name('product.update')->middleware('auth');
Route::delete('/product/{product}', 'ProductController@destroy')->name('product.destroy')->middleware('auth');

// Category
Route::get('/category', 'CategoryController@index')->name('category.index');
Route::post('/category', 'CategoryController@store')->name('category.store')->middleware('auth');
Route::get('/category/create', 'CategoryController@create')->name('category.create')->middleware('auth');
Route::get('/category/edit/{category}', 'CategoryController@edit')->name('category.edit')->middleware('auth');
Route::get('/category/{category}', 'CategoryController@show')->name('category.show');
Route::put('/category/{category}', 'CategoryController@update')->name('category.update')->middleware('auth');
Route::delete('/category/{category}', 'CategoryController@destroy')->name('category.destroy')->middleware('auth');
// Section
Route::get('/section', 'SectionController@index')->name('section.index');
Route::post('/section', 'SectionController@store')->name('section.store')->middleware('auth');
Route::get('/section/create', 'SectionController@create')->name('section.create')->middleware('auth');
Route::get('/section/edit/{section}', 'SectionController@edit')->name('section.edit')->middleware('auth');
Route::get('/section/{section}', 'SectionController@show')->name('section.show');
Route::put('/section/{section}', 'SectionController@update')->name('section.update')->middleware('auth');
Route::delete('/section/{section}', 'SectionController@destroy')->name('section.destroy')->middleware('auth');
// Image
// Route::get('/image', 'ImageController@index')->name('image.index');
// Route::post('/image', 'ImageController@store')->name('image.store')->middleware('auth');
// Route::get('/image/create', 'ImageController@create')->name('image.create')->middleware('auth');
Route::get('/image/edit/{image}', 'ImageController@edit')->name('image.edit')->middleware('auth');
// Route::get('/image/{image}', 'ImageController@show')->name('image.show');
Route::put('/image/{image}', 'ImageController@update')->name('image.update')->middleware('auth');
// Route::delete('/image/{image}', 'ImageController@destroy')->name('image.destroy')->middleware('auth');

// Darinajumi
// Route::get('/darinajumi', 'DarinajumiController@index')->name('darinajumi.index');
// Route::post('/darinajumi', 'DarinajumiController@store')->name('darinajumi.store')->middleware('auth');
// Route::get('/darinajumi/create', 'DarinajumiController@create')->name('darinajumi.create')->middleware('auth');
// Route::get('/darinajumi/edit/{darinajumi}', 'DarinajumiController@edit')->name('darinajumi.edit')->middleware('auth');
// Route::get('/darinajumi/{darinajumi}', 'DarinajumiController@show')->name('darinajumi.show');
// Route::put('/darinajumi/{darinajumi}', 'DarinajumiController@update')->name('darinajumi.update')->middleware('auth');
// Route::delete('/darinajumi/{darinajumi}', 'DarinajumiController@destroy')->name('darinajumi.destroy')->middleware('auth');

// Grozs
// Route::get('/grozs', 'GrozsController@index')->name('grozs.index');
// Route::get('/grozs/pievienot/{product}', 'GrozsController@addToCart')->name('grozs.add');
// Route::put('/grozs/izmainit/{product}', 'GrozsController@update')->name('grozs.update');
// Route::delete('/grozs/{product}', 'GrozsController@delete')->name('grozs.delete');

// Invoice
// Route::get('/grozs/rekins', 'GrozsController@invoice')->name('grozs.invoice');
// Route::get('/grozs/rekins/pdf', 'GrozsController@invoicePdf')->name('grozs.invoice-pdf');

// Need to be last otherwise laravel will use all routes as variables for product
Route::get('/{product}', 'ProductController@show')->name('product.show');
