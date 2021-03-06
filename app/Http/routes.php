<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('user/index', 'UserController@index');
Route::get('user/jwt', 'UserController@JWT');
Route::get('user/verify_token', 'UserController@verifyToken');

//Route::get('work_man/start', 'WorkerManController@start');//console 中开启
Route::get('work_man/message', 'WorkerManController@message');

Route::get('queryList/act', 'QueryListController@act');

Route::get('workerman/message', 'WorkermanController@message');

Route::get('elasticsearch/action', 'ElasticsearchController@action');
Route::get('elasticsearch/setIndex', 'ElasticsearchController@setIndex');
Route::get('elasticsearch/getAll', 'ElasticsearchController@getAll');
Route::get('elasticsearch/getAll', 'ElasticsearchController@getAll');
Route::get('elasticsearch/search', 'ElasticsearchController@search');
Route::post('elasticsearch/del', 'ElasticsearchController@del');
Route::get('elasticsearch/get', 'ElasticsearchController@get');


Route::get('hook/test1', 'HookController@test');