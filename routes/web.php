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
Route::put('api/post/comment/{cid}', 'CommentController@edit');

// User
Route::get('user/edit', 'UserController@edit')->middleware('auth');
Route::get('user/{username}', 'UserController@show');
Route::post('user/edit', 'UserController@editProfile');
Route::post('user/photo', 'UserController@uploadImage');

// Admin
Route::get("/api/admin/users", "UserController@getAllUsers")->middleware("admin");
Route::get("/api/admin/user/{uname}", "UserController@getUserDetails")->middleware("admin");
Route::put("/api/admin/user/{uid}/block", "UserController@blockUser")->middleware("admin");
Route::put("/api/admin/user/{uid}/block", "UserController@blockUser")->middleware("admin");
Route::delete("/api/admin/user/{uid}/deletePosts", "UserController@deleteUsersPosts")->middleware("admin");
Route::delete("/api/admin/user/{uid}/deleteComments", "UserController@deleteUsersComments")->middleware("admin");
Route::view("/admin/users", "pages.admin.users")->middleware("admin");
Route::view("admin", "pages.admin.index")->middleware("admin");

Route::get("admin/universities", "UniversityController@manage")->middleware("admin");
Route::post("university", "UniversityController@create")->middleware("admin");
Route::get("university/{id}/edit", "UniversityController@edit")->middleware("admin");
Route::post("university/{id}/edit", "UniversityController@update")->middleware("admin");
Route::delete("university/{id}", "UniversityController@destroy")->middleware("admin");

Route::get("admin/faculties/{id}", "FacultyController@manage")->middleware("admin");
Route::post("faculty", "FacultyController@create")->middleware("admin");
Route::get("faculty/{id}/edit", "FacultyController@edit")->middleware("admin");
Route::post("faculty/{id}/edit", "FacultyController@update")->middleware("admin");
Route::delete("faculty/{id}", "FacultyController@destroy")->middleware("admin");

Route::get("admin/cities", "CityController@manage")->middleware("admin");
Route::post("city", "CityController@create")->middleware("admin");
Route::get("city/{id}/edit", "CityController@edit")->middleware("admin");
Route::post("city/{id}/edit", "CityController@update")->middleware("admin");
Route::delete("city/{id}", "CityController@destroy")->middleware("admin");