<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//php artisan scribe:generate
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/', function () { echo 'worked!'; });
    Route::get('menu', 'Api\CommonController@menu');
    Route::get('home-post', 'Api\CommonController@homePosts');
    Route::get('menu-post/{slug}', 'Api\CommonController@menuPosts');
    Route::get('post/{slug}', 'Api\CommonController@postDetails');

    Route::group(['prefix' => 'classified'], function () {
        Route::get('category', 'Api\ClassifiedController@category');
        Route::get('category-post/{slug}', 'Api\ClassifiedController@categoryPosts');
        Route::get('filter-post', 'Api\ClassifiedController@filterPosts');
        Route::get('home-post', 'Api\ClassifiedController@homePosts');
    });

    Route::group(['middleware' => ['auth:sanctum']], function() {
        
    });
});
