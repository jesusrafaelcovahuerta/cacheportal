<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->get('/athenticated', function () {
    return true;
});
Route::post('register', 'RegisterController@register');
Route::post('login', 'LoginController@login');
Route::post('logout', 'LoginController@logout');
Route::get('section', 'SectionController@index');
Route::get('alliance', 'api\AllianceController@index');
Route::get('alliance/{rut}/edit', 'api\AllianceController@edit');
Route::post('alliance/update/{rut}', 'api\AllianceController@update');
Route::get('alliance/activate/{rut}', 'api\AllianceController@activate');
Route::post('alliance/store', 'api\AllianceController@store');
Route::get('alliance/list', 'api\AllianceController@list');
Route::get('alliance/destroy/{id}', 'api\AllianceController@destroy');
Route::get('section', 'api\SectionController@index');
Route::get('section/{rut}/edit', 'api\SectionController@edit');
Route::get('section/list', 'api\SectionController@list');
Route::post('section/update/{rut}', 'api\SectionController@update');
Route::get('section/destroy/{id}', 'api\SectionController@destroy');
Route::post('section/store', 'api\SectionController@store');
Route::get('section/activate/{id}', 'api\SectionController@activate');
Route::get('category', 'api\CategoryController@index');
Route::get('category/{id}/edit', 'api\CategoryController@edit');
Route::post('category/store', 'api\CategoryController@store');
Route::get('category/destroy/{id}', 'api\CategoryController@destroy');
Route::get('category/show/{id}', 'api\CategoryController@show');
Route::get('category/list', 'api\CategoryController@list');
Route::post('category/update/{id}', 'api\CategoryController@update');
Route::resource('content', 'api\ContentController');
Route::post('content/store', 'api\ContentController@store');
Route::get('user', 'api\UserController@index');
Route::post('user/store', 'api\UserController@store');
Route::get('user/{rut}/edit', 'api\UserController@edit');
Route::post('user/update/{rut}', 'api\UserController@update');
Route::get('user/destroy/{id}', 'api\UserController@destroy');
Route::get('user/activate/{rut}', 'api\UserController@activate');
Route::get('user/rol', 'api\UserController@rol');
Route::get('user/rut', 'api\UserController@rut');
Route::post('user/catch', 'api\UserController@catch');
Route::get('section/home', 'api\SectionController@home');
Route::get('poll', 'api\PollController@index');
Route::get('poll/{rut}/edit', 'api\PollController@edit');
Route::post('poll/update/{rut}', 'api\PollController@update');
Route::get('poll/activate/{rut}', 'api\PollController@activate');
Route::post('poll/store', 'api\PollController@store');
Route::get('poll/list', 'api\PollController@list');
Route::get('poll/destroy/{id}', 'api\PollController@destroy');
Route::get('content/show/{id}', 'api\ContentController@show');
Route::get('content/detail/{id}', 'api\ContentController@detail');
Route::get('content/{id}/edit', 'api\ContentController@edit');
Route::post('content/update/{id}', 'api\ContentController@update');
Route::get('content/destroy/{id}', 'api\ContentController@destroy');
Route::get('content/accept/{id}', 'api\ContentController@accept');
Route::get('content/image/{id}', 'api\ContentController@image');
Route::post('audit/store', 'api\AuditController@store');
Route::get('poll/show/{id}', 'api\PollController@show');
Route::post('poll/answer', 'api\PollController@answer');
Route::get('audit', 'api\AuditController@index');
Route::get('section/move/{id}/{position}', 'api\SectionController@move');
Route::get('category/move/{id}/{position}', 'api\CategoryController@move');
Route::get('metric', 'api\MetricController@index');