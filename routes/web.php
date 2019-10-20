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

Route::get('/', 'Core\Auth\LoginController@index')->name('front');
Route::get('login', 'Core\Auth\LoginController@index')->name('login');
Route::get('logout', 'Core\Auth\LogoutController@index')->name('logout');
Route::post('/dologin', 'Core\Auth\LoginController@check_login')->name('logindo');

Route::group(['middleware' => 'check.authentication'], function () {
    /* Dashboard */
    Route::get('dashboard', 'Core\Member\DashboardController@index')->name('dashboard');
    

    /* Route For Super Admin */
    /* How To Create Middleware for specified user group
    1. Create Middleware. Example SuperAdminMiddleware.php
    2. Change $group_name to user group name
    3. Register to routeMiddleware in kernel.php. Example
        'check.superadmin' => \App\Http\Middleware\SuperAdminMiddleware::class,
    */
    Route::group(['middleware'=>'check.superadmin'],function(){
        
    
        /* Core Prefix*/
        Route::prefix('core')->group(function(){
            /* User Management */
            Route::prefix('users')->group(function(){
                Route::get('group', 'Core\Users\GroupController@index')->name('core.users.group');
                Route::get('group/get', 'Core\Users\GroupController@get_user_group')->name('core.users.group.get');
                Route::post('group/store', 'Core\Users\GroupController@store')->name('core.users.group.store');
                Route::get('group/edit/{id}', 'Core\Users\GroupController@edit')->name('core.users.group.edit');
                Route::get('group/delete/{id}', 'Core\Users\GroupController@delete')->name('core.users.group.delete');
                Route::post('group/update', 'Core\Users\GroupController@update')->name('core.users.group.update');
                Route::get('user', 'Core\Users\UserController@index')->name('core.users.user');
                Route::get('user/get', 'Core\Users\UserController@get_data')->name('core.users.user.get');
                Route::get('user/add', 'Core\Users\UserController@add')->name('core.users.user.add');
                Route::post('user/store', 'Core\Users\UserController@store')->name('core.users.user.store');
                Route::post('user/update', 'Core\Users\UserController@user_update')->name('core.users.user.update');
                Route::post('user/avatar/update/{id}', 'Core\Users\UserController@avatar_update')->name('core.users.user.avatarupdate');
                Route::get('user/detail/{id}', 'Core\Users\UserController@detail')->name('core.users.user.detail');
                Route::get('user/delete/{id}', 'Core\Users\UserController@delete')->name('core.users.user.delete');
            });

            /* Configuration */
            Route::prefix('config')->group(function(){
                Route::get('general/{prefix}', 'Core\Config\GeneralController@index')->name('core.config.general');
                Route::post('general/update', 'Core\Config\GeneralController@update')->name('core.config.general.update');
                Route::get('logo', 'Core\Config\LogoController@index')->name('core.config.logo');
            });

             
        });
    });

    /* User Route */
    Route::prefix('core')->group(function(){
        Route::prefix('user')->group(function(){
            Route::get('profile', 'Core\Member\ProfileController@index')->name('user.profile');
            Route::post('profile/update', 'Core\Member\ProfileController@profile_update')->name('user.profile.update');
            Route::post('profile/avatar/update', 'Core\Member\ProfileController@avatar_update')->name('user.profile.avatar.update');
        });
    });
    
    


    /* SET ROUTE WITH AUTHENTICATION BACKEND HERE */

});

/* SET ROUTE WITHOUT AUTHENTICATION BACKEND HERE */
