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
Route::group(array('prefix' => 'backend'), function() {
    Route::get('/backend', function () {
        return view('backend.dashboard');
    });
    Route::get("pages/index",["as"=>"pageslisting","uses"=>"Backend\PagesController@getIndex"]);
    Route::get("pages/addnew",['as'=>'addnewpage',"uses"=>"Backend\PagesController@getAddNew"]);
    Route::post("pages/addnew",["uses"=>"Backend\PagesController@postAddNew"]);
    Route::get("pages/edit/{id?}",["as"=>"editpage","uses"=>"Backend\PagesController@getEditPage"]);
    Route::post("pages/edit/{id?}",["uses"=>"Backend\PagesController@postEditPage"]); // Used for all kinds of post table delete

    /**
     * Route for post
     */

    Route::get("posts/index",["as"=>"postslisting","uses"=>"Backend\PostsController@getIndex"]);
    Route::get("posts/addnew/{type?}",['as'=>'addnewpost',"uses"=>"Backend\PostsController@getAddNew"]);
    Route::get("posts/edit/{id?}",["as"=>"editpost","uses"=>"Backend\PostsController@getEditPost"]);
    Route::post("posts/addnew/{type?}",["uses"=>"Backend\PostsController@postAddNew"]);
    Route::post("posts/edit/{type?}",["uses"=>"Backend\PostsController@postEditPost"]);
    Route::get("posts/categories",["uses"=>"Backend\PostsController@getPostCategoryList"]);
    Route::post("posts/categories",['uses'=>"Backend\PostsController@postPostCategory"]);

    /**
     * Route for Event
     */

    Route::get("events/index",["as"=>"eventlisting","uses"=>"Backend\EventsController@getIndex"]);
    Route::get('events/addnew', array('as'=>'addnewevent','uses'=>'Backend\EventsController@getAddNew'));
    Route::get("events/edit/{id?}",["as"=>"editevent","uses"=>"Backend\EventsController@getEditEvent"]);
    Route::post('events/addnew', array('uses'=>'Backend\EventsController@postAddNew'));
    Route::post("events/edit/{id?}",["uses"=>"Backend\EventsController@postAddNew"]);
    Route::get("events/categories",["uses"=>"Backend\EventsController@getEventCategoryList"]);
    Route::post("events/categories",['uses'=>"Backend\EventsController@postEventCategory"]);

    /**
     * Route for menu
     */
    Route::get("menu/index/{id?}",array("as"=>"menuhome","uses"=>"Backend\MenuController@getIndex"));
    Route::post("menu/index",array("as"=>"index","uses"=>'Backend\MenuController@postMenuHome'));

    /**
     * Route for sliders
     */

    Route::get("sliders/index/{id?}",["as"=>"sliderhome","uses"=>"Backend\SlidersController@index"]);
    Route::post("sliders/index/{id?}",["uses"=>"Backend\SlidersController@postIndex"]);
});