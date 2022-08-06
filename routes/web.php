<?php

use Illuminate\Support\Facades\Route;

/* Test Route::START */
Route::group(['prefix' => 'command'], function () {
    Route::get('clear', function () {
        \Artisan::call('cache:clear');
        \Artisan::call('config:clear');
        \Artisan::call('route:clear');
        \Artisan::call('view:clear');
        dd("All clear!");
    });

    Route::get('/storage-link', function () {
        Artisan::call('storage:link');
        dd("Added!");
    });

    Route::get('/down', function () {
        Artisan::call('down');
        dd("maintenance mode Enabled!");
    });

    Route::get('/up', function () {
        Artisan::call('up');
        dd("maintenance mode Disabled!");
    });
});
/* Test Route::END */

Route::group(['namespace' => 'App\Http\Controllers', 'prefix' => 'migrate'], function () {
    Route::get('users', 'DataMigrationController@users');
    Route::get('categories', 'DataMigrationController@categories');
    Route::get('posts', 'DataMigrationController@posts');
});


/* Admin Route::START */
Route::group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    // Authentication Routes...
    Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/', 'Auth\LoginController@login');

    // Password Reset Routes...
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

    Route::group(['middleware' => ['auth:admin']], function () {
        // Password Reset Routes...
        Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
        Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
        Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');

        Route::post('logout', 'Auth\LoginController@logout')->name('logout');

        Route::group(['middleware' => ['admin.verified']], function () {
            Route::get('dashboard', 'DashboardController@index')->name('dashboard');

            Route::get('profile', 'ProfileController@index')->name('profile');
            Route::post('profile', 'ProfileController@update');
            Route::get('profile/password', 'ProfileController@password')->name('profile.password');
            Route::post('profile/password', 'ProfileController@passwordUpdate');

            Route::resource('staff', 'StaffController');
            Route::resource('role', 'RoleController')->except('show');

            Route::post('category/sort', 'CategoryController@sortRow')->name('category.sort');
            Route::get('category/home', 'CategoryController@homeCategory')->name('category.home');
            Route::post('category/home/sort', 'CategoryController@homeSortRow')->name('category.home.sort');
            Route::resource('category', 'CategoryController');

            Route::put('post/approve/{id}', 'PostController@approve')->name('post.approve');
            Route::post('post/image-destory', 'PostController@destroyImage')->name('post.image-destory');
            Route::resource('post', 'PostController');

            Route::resource('page', 'PageController');

            Route::post('menu/sort', 'MenuController@sortRow')->name('menu.sort');
            Route::resource('menu', 'MenuController');

            Route::group(['prefix' => 'classified', 'as' => 'classified.'], function () {
                Route::post('category/sort', 'Classified\CategoryController@sortRow')->name('category.sort');
                Route::resource('category', 'Classified\CategoryController');

                Route::put('post/approve/{id}', 'Classified\PostController@approve')->name('post.approve');
                Route::resource('post', 'Classified\PostController');
            });
        });
    });
});
/* Admin Route::END */



Route::view('/classified/{react?}', 'layouts.classified')->where('react', '.*');
Route::view('/{path?}', 'layouts.app');
