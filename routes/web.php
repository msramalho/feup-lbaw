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
Auth::routes();

Route::view('/', 'pages.index');

// Static Pages
Route::view('about', 'pages.static.about');
Route::view('contacts', 'pages.static.contacts');
Route::view('faq', 'pages.static.faq');
Route::view('statistics', 'pages.static.statistics');
// Route::view('recover-password', 'pages.static.recover-password');

// News Posts
Route::view('post', 'pages.post');

// Cards
// Route::get('cards', 'CardController@list');
// Route::get('cards/{id}', 'CardController@show');

// API
// Route::put('api/cards', 'CardController@create');
// Route::delete('api/cards/{card_id}', 'CardController@delete');
// Route::put('api/cards/{card_id}/', 'ItemController@create');
// Route::post('api/item/{id}', 'ItemController@update');
// Route::delete('api/item/{id}', 'ItemController@delete');

// Authentication

Route::get('login', function () {return redirect('/?action=login');});
Route::post('login', 'Auth\LoginController@login');
Route::get('register', function () {return redirect('/?action=register');});
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::post('register', 'Auth\RegisterController@register');

Route::get('user/edit', 'UserController@edit');
Route::get('user/{username}', 'UserController@show');

// Custom error pages
Route::view('404', 'errors.404');
Route::view('403', 'errors.403');