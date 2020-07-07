<?php

use App\User;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;


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

Route::post('/user/create', 'UserController@create');

Route::post('/user/login', 'UserController@login');

Route::post('/user/confirm', 'UserController@confirm')->middleware('checktoken');

Route::post('/user/gameover', 'UserController@gameover')->middleware('checktoken');

Route::post('/user/showrank', 'RankController@showrank');

// Gacha routes

Route::post('/user/creategacha', 'GachaController@creategacha');
