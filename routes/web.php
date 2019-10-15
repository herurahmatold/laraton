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
    /* Dashboard */
    Route::get('dashboard', 'Core\Member\DashboardController@index')->name('dashboard');
    

    /* Core Prefix*/
    Route::prefix('core')->group(function(){
        /* User Management */
        Route::get('users/group', 'Core\Users\GroupController@index')->name('core.users.group');
        Route::get('users/user', 'Core\Users\UserController@index')->name('core.users.user');
        

        /* Configuration */
        Route::get('config/general/{prefix}', 'Core\Config\GeneralController@index')->name('core.config.general');
        Route::get('config/logo', 'Core\Config\LogoController@index')->name('core.config.logo');

        /* User Route */
        Route::prefix('user')->group(function(){
            Route::get('profile', 'Core\Member\ProfileController@index')->name('user.profile');
            Route::post('profile/update', 'Core\Member\ProfileController@profile_update')->name('user.profile.update');
            Route::post('profile/avatar/update', 'Core\Member\ProfileController@avatar_update')->name('user.profile.avatar.update');
        });        
    });
    


    /* SET ROUTE WITH AUTHENTICATION BACKEND HERE */

});

/* SET ROUTE WITHOUT AUTHENTICATION BACKEND HERE */
