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
Route::get('post', 'PostController@new')->middleware('auth');
Route::post('post', 'PostController@create');
Route::get('post/{id}', 'PostController@show');
Route::get('post/{id}/edit', 'PostController@edit');
Route::post('post/{id}/edit', 'PostController@update');
Route::get('post/{id}/delete', 'PostController@delete');

// Faculties api
Route::get('api/university/{id}/faculties', 'FacultyController@list')->middleware('auth');

// Votes
Route::post("post/{id}/vote", "VoteController@create")->middleware('auth');

// Authentication
Route::get('login', function () {return redirect('/?action=login');})->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('register', function () {return redirect('/?action=register');});
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::post('register', 'Auth\RegisterController@register');

// Custom error pages
Route::view('404', 'errors.404');
Route::view('403', 'errors.403');


// Comments
Route::post('api/post/{id}/comment', 'CommentController@create');
Route::delete('api/post/comment/{cid}', 'CommentController@delete');

// User
Route::get('user/edit', 'UserController@edit')->middleware('auth');
Route::get('user/{username}', 'UserController@show');
Route::post('user/edit', 'UserController@editProfile');
Route::post('user/photo', 'UserController@uploadImage');

// Admin
Route::get("/api/admin/users", "UserController@getAllUsers")->middleware("admin");
Route::view("admin", "pages.admin.index")->middleware("admin");
Route::get("admin/universities", "UniversityController@manage")->middleware("admin");
Route::post("university", "UniversityController@create")->middleware("admin");