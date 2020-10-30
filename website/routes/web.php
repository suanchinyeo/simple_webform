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

Route::get('/', 'MainPageController@home');
Route::post('/questions', 'MainPageController@storequestion');
Route::post('/answers', 'MainPageController@storeanswer');
Route::get('/{type}', 'MainPageController@show');
