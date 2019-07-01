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
    Route::get('/competitor', 'CompareController@index')->name('competitor');

    Route::get('/trend', 'TrendingController@index')->name('trend');
    Route::get('/trend/detail/{id_trend}', 'TrendingController@detail');

    Route::get('/engage', 'EngageController@index')->name('engage');
    Route::get('/engage/search/{username}', 'EngageController@search');
    Route::get('/engage/account/{username}', 'EngageController@addAccount');
    // Route::get('/engage/account', 'EngageController@showAccount');

    Route::get('dashboard/profile', 'DashboardController@showProfile');
    Route::get('dashboard/showRecommendation', 'DashboardController@showRecommendation');
    Route::get('dashboard/showFollowers', 'DashboardController@showFollowers');
    Route::get('dashboard/showPosting', 'DashboardController@showPosting');
    Route::get('dashboard/showRetweet', 'DashboardController@showRetweet');
    Route::get('dashboard/showLikes', 'DashboardController@showLikes');
    Route::get('dashboard/showReplies', 'DashboardController@showReplies');
    Route::get('dashboard/showInsight', 'DashboardController@showInsight');
    Route::get('dashboard/showSentiment', 'DashboardController@showSentiment');
    Route::get('dashboard/showTopTweets', 'DashboardController@showTopTweets');
    Route::get('dashboard/updateAccountData', 'DashboardController@updateAccountData');
    Route::get('dashboard/updateSentimentData', 'DashboardController@updateSentimentData');
    Route::get('dashboard/updateBestTweet', 'DashboardController@updateBestTweet');
    Route::get('dashboard/updateTrendingTopic', 'DashboardController@updateTrendingTopic');
    Route::get('dashboard/checkUpdate', 'DashboardController@checkUpdate');

    Route::get('/compare/search/{username}', 'CompareController@search');
    Route::get('/compare/add/{username}', 'CompareController@addAccount');
    Route::get('/compare/delete/{competitor_id}', 'CompareController@deleteAccount');
    Route::get('/compare/id/{id}', 'CompareController@compare');
    Route::get('/compare/showCompetitor/{id}', 'CompareController@showCompetitorAccount');
    Route::get('/compare/showComparison/{id}', 'CompareController@showComparisonAccount');
});
