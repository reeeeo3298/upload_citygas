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

Route::get('/','UploadController@index');
Route::get('/login','UploadController@login');

//一覧画面
Route::get('/list','UploadController@list_index');

//一覧画面(詳細ボタン押下)
Route::get('/lpio_upload/data_detail','UploadController@data_detail');

//一覧画面(検索ボタン押下)
Route::get('/customer_search','UploadController@search_index');

//一覧画面(csvボタン押下)
Route::get('/csv','UploadController@csv_index');

//登録画面
Route::get('/add','UploadController@add_index');

//登録完了処理
Route::post('/add_complete','UploadController@add_input');

//登録保留処理
Route::post('/hold_complete','UploadController@hold_input');
