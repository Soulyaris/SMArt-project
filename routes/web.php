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

Route::match(array('GET', 'POST'),'/', 'GalleryController@index')->name('gallery');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::match(array('GET', 'POST'), '/users', 'UserController@index');
Route::get('/users/{user}/delete', 'UserController@delete')->name('users.delete');
Route::get('/users/{user}/delete-confirmed', 'UserController@deleteConfirmed')->name('users.delete.confirmed');
Route::post('/users/{user}/update', 'UserController@update')->name('users.update');
Route::resource('/users', 'UserController', ['except' => ['create', 'store', 'destroy', 'update']]);

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function(){
    Route::prefix('categories')->name('categories.')->group(function(){
        Route::get('/', 'CategoryModelController@index')->name('index');
        Route::get('/add', 'CategoryModelController@add')->name('add');
        Route::post('/create', 'CategoryModelController@create')->name('create');
        Route::get('/{category}/edit', 'CategoryModelController@edit')->name('edit');
        Route::post('/{category}/update', 'CategoryModelController@update')->name('update');
        Route::get('/{category}/delete', 'CategoryModelController@delete')->name('delete');
        Route::get('/{category}/delete-confirmed', 'CategoryModelController@deleteConfirmed')->name('delete.confirmed');
    });
});

Route::prefix('image')->name('image.')->middleware('auth')->group(function(){
    Route::get('/{user}/show/{image}','ImageModelController@show')->withoutMiddleware('auth')->name('show');
    Route::get('/add', 'ImageModelController@add')->name('add');
    Route::post('/create', 'ImageModelController@create')->name('create');
    Route::get('/{user}/edit/{image}','ImageModelController@edit')->name('edit');
    Route::post('/{user}/update/{image}','ImageModelController@update')->name('update');
    Route::get('/{user}/delete/{image}','ImageModelController@delete')->name('delete');
    Route::get('/{user}/delete-confirmed/{image}','ImageModelController@deleteConfirmed')->name('delete.confirmed');
    Route::post('/{image}/rate', 'RatingModelController@rate')->name('rate');
});

Route::prefix('comment')->name('comment.')->middleware('auth')->group(function(){
    Route::post('/{image}/create', 'CommentModelController@create')->name('create');
    Route::get('/{comment}/edit','CommentModelController@edit')->name('edit');
    Route::post('/{comment}/update','CommentModelController@update')->name('update');
    Route::get('/{comment}/delete','CommentModelController@delete')->name('delete');
    Route::get('/{comment}/delete-confirmed','CommentModelController@deleteConfirmed')->name('delete.confirmed');
});

Route::get('/tops', 'TopsController@index')->name('tops');
