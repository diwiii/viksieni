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

Route::get('/', 'PageController@index')->name('root');

Route::post('/product', 'ProductController@store')->middleware('auth');
Route::get('/product/create', 'ProductController@create')->name('product.create')->middleware('auth');


/**
 * Authentication routes
 * Disabled routes: register, reset, confirm
 */
Auth::routes([
    'register' => false,
    'reset' => false,
    'confirm' => false
    ]);

//Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout'); //Kā tas strādā?
Route::get('/home', 'HomeController@index')->name('home');
