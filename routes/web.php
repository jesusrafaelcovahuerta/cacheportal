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

Auth::routes();
Route::get('/account', 'AccountController@index');
Route::get('/section', 'SectionController@index');
Route::get('/alliance', 'AllianceController@index');
Route::get('/category', 'CategoryController@index');
Route::get('/category/show/{id}', 'CategoryController@show');
Route::get('/section/show/{id}', 'SectionController@show');
Route::get('/content/show/{id}', 'ContentController@show');
Route::get('/content', 'ContentController@index');
Route::get('/poll', 'PollController@index');
Route::get('/poll/create', 'PollController@create');
Route::get('/poll/show/{id}', 'PollController@show');
Route::post('/enter', 'LoginController@login');
Route::get('/', 'HomeController@index');
Route::get('/login/logout', 'LoginController@logout');

/*
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
*/