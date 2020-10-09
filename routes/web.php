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

// use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Route;


Route::get('/', 'GambarController@index');
// Route::post('/', 'GambarController@tambahData')->name('upload');
Route::get('/upload', 'GambarController@tambahData')->name('upload');
Route::post('/upload', 'GambarController@insert');

Route::view('login', 'login');
Route::post('login', 'Login@index');
Route::get('logout', 'Login@exit');


// Route::post('/', function () {
//     dd(request()->all());
// });
