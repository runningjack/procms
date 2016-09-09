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

Route::get('/backend', function () {
    return view('backend.dashboard');
});
Route::get("/backend/pages/index",["as"=>"pageslisting","uses"=>"Backend\PagesController@getIndex"]);
Route::get("/backend/pages/addnew",['as'=>'addnewpage',"uses"=>"Backend\PagesController@getAddNew"]);
Route::post("/backend/pages/addnew",["uses"=>"Backend\PagesController@postAddNew"]);
Route::get("/backend/pages/edit/{id?}",["as"=>"editpage","uses"=>"Backend\PagesController@getEditPage"]);

