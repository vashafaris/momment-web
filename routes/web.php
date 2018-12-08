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

Route::group([], function() {
    Route::get('login', 'UserManagementController@showLoginForm')->name('login');
    Route::get('register', 'UserManagementController@showRegisterForm')->name('register');
    Route::get('reset', 'UserManagementController@showRegisterForm');
    Route::get('forgot', 'UserManagementController@showForgotForm');
    Route::get('logout', 'UserManagementController@logout')->name('logout');

    Route::post('login', 'UserManagementController@submitLoginForm');
    Route::post('register', 'UserManagementController@submitRegisterForm');
    Route::post('forgot', 'UserManagementController@submitForgotForm');
    Route::post('logout', 'UserManagementController@logout')->name('logout');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::get('/compare', 'CompareController@index')->name('compare');

    Route::get('/trends', 'TrendingController@index')->name('trends');

    Route::get('/engage', 'EngageController@index')->name('engage');
    Route::get('/engage/search/{username}', 'EngageController@search');
    Route::get('/engage/account/{username}', 'EngageController@addAccount');
    Route::get('/engage/account', 'EngageController@showAccount');

    Route::get('/compare/search/{username}', 'CompareController@search');
    Route::get('/compare/add/{username}', 'CompareController@addAccount');
});
