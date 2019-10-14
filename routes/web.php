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

Route::get('/', 'Core\Auth\LoginController@index');
Route::get('login', 'Core\Auth\LoginController@index')->name('login');
Route::get('logout', 'Core\Auth\LogoutController@index')->name('logout');
Route::post('/dologin', 'Core\Auth\LoginController@check_login')->name('logindo');

Route::group(['middleware' => 'check.authentication'], function () {
    Route::get('dashboard', 'Core\Member\DashboardController@index')->name('dashboard');
    Route::get('dashboard/tes', 'Core\Member\DashboardController@index_tes')->name('dashboard.tes');
    Route::get('core/users/group', 'Core\Member\DashboardController@index')->name('core.users.group');
    Route::get('core/users/user', 'Core\Member\DashboardController@index')->name('core.users.user');
    Route::get('user/profile', 'Core\Member\DashboardController@index')->name('user.profile');

    /* SET ROUTE WITH AUTHENTICATION BACKEND HERE */

});

/* SET ROUTE WITHOUT AUTHENTICATION BACKEND HERE */
