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
    return view('welcome');
});
# /folders/{フォルダID}/tasks
# TaskController コントローラーの index メソッドを呼びだす
# routeに名前をつける
# アプリケーションの中で URL を参照する際にはこの名前を使う
Route::get('/folders/{id}/tasks', 'TaskController@index')->name('tasks.index');
