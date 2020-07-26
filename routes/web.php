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

Route::get('/', function () {
    return view('main');
})->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::match(array('GET', 'POST'), '/users', 'UserController@index');
Route::get('/users/{user}/delete', 'UserController@delete')->name('users.delete');
Route::get('/users/{user}/delete-confirmed', 'UserController@deleteConfirmed')->name('users.delete.confirmed');
Route::post('/users/{user}/update', 'UserController@update')->name('users.update');
Route::resource('/users', 'UserController', ['except' => ['create', 'store', 'destroy', 'update']]);

Route::prefix('admin')->name('admin.')->group(function(){
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
