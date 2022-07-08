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
Route::get('/alliance/create', 'AllianceController@create');
Route::get('/alliance/edit/{id}', 'AllianceController@edit');
Route::get('/category', 'CategoryController@index');
Route::get('/category/create', 'CategoryController@create');
Route::get('/category/edit/{id}', 'CategoryController@edit');
Route::get('/category/show/{id}', 'CategoryController@show');
Route::get('/section/create', 'SectionController@create');
Route::get('/section/edit/{id}', 'SectionController@edit');
Route::get('/section/show/{id}', 'SectionController@show');
Route::get('/content/show/{id}', 'ContentController@show');
Route::get('/content', 'ContentController@index');
Route::get('/content/create', 'ContentController@create');
Route::get('/content/edit/{id}', 'ContentController@edit');
Route::get('/poll', 'PollController@index');
Route::get('/poll/create', 'PollController@create');
Route::get('/poll/show/{id}', 'PollController@show');
Route::post('/enter', 'LoginController@login');
Route::get('/', 'HomeController@index');
Route::get('/login/logout', 'LoginController@logout');
Route::get('/login/success', 'LoginController@index');
Route::get('/rut', 'RutController@index');
Route::get('/rut/error', 'RutController@index');
Route::post('/rut/verify', 'RutController@verify');
Route::get('/question', 'QuestionController@index');
Route::get('/question/error', 'QuestionController@index');
Route::post('/question/verify', 'QuestionController@verify');
Route::get('/password', 'PasswordController@index');
Route::get('/password/{code}', 'PasswordController@index');
Route::post('/password/update', 'PasswordController@update');
Route::get('/user', 'UserController@index');

/*
Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');
*/