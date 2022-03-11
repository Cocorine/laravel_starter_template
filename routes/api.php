<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* 
    Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
        return $request->user();
    });
*/

Route::group(['middleware' => ['cors', 'json.response'], 'as' => 'api.', 'prefix' => 'v1', 'namespace' => 'App\Http\Controllers\API'], function () {

    Route::group(['prefix' => 'auths', 'as' => 'auths.'], function () {

        /* 
            Route::controller('AuthController')->group(function () {

                Route::post('/login','AuthController@login')->name('login');

                Route::group(['middleware' => ['auth:api']], function () {

                    Route::get('/get-authenticate-user-data', 'AuthController@getAuthenticateUserData')->name('user');

                    Route::post('/logout','AuthController@logout')->name('logout');

                });

            }); 
        */
    });



    Route::group(['middleware' => ['auth:api']], function () {
        
        /**
         *
         * User's api resource routes
         */
        Route::apiResource('users', 'UserController')->names('users'); // embed all users's controller api function route
        /* 

            Route::controller('UserController')->group(function () {

                Route::get('/delete/{user}','UserController@delete')->name('delete');

                Route::get('/get-list-of-all-users','UserController@get_list_of_all_users')->name('all-users');

                Route::post('/get-user-data','UserController@getUserData')->name('getUserData');

            });

        */

        /**
         *
         * Permission's api resource routes
         */
        Route::apiResource('permissions', 'PermissionController')->names('permissions'); // embed all permission's controller api function route
        /* 

            Route::controller('PermissionController')->group(['as' => 'permissions.'],function () {

                Route::get('/delete/{permission}','PermissionController@delete')->name('delete');
                Route::get('/get-list-of-all-permissions','PermissionController@get_list_of_all_permissions')->name('all-permissions');

            });

        */

        /**
         *
         * Role's api resource routes
         */
        Route::apiResource('roles', 'RoleController')->names('roles'); // embed all role's controller api function route
        /* 

            Route::controller('RoleController')->group(['as' => 'roles.'],function () {

                Route::get('/delete/{role}','RoleController@delete')->name('delete');
                Route::get('/get-list-of-all-roles','RoleController@get_list_of_all_roles')->name('all-roles');

            });

        */

        /* 
            Route::controller('AppController')->group(function () {

                Route::get('/get-list-notifications','AppController@getNotifications')->name('notiifications.list');

                Route::get('/get-settings','AppController@getSettings')->name('settings.list');

                Route::get('/get-settings/{setting}','AppController@getSetting')->name('settings.show');

                Route::get('/get-list-prospects','AppController@getProspects')->name('prospects.list');

                Route::post('/add-new-prospect','AppController@addProspect')->name('prospects.store');
                
            }); 
        */

        Route::group(['as' => 'trafics.', 'prefix' => 'trafics'], function () {

            Route::get('/get-list-trafics', 'TraficController@get_trafics')->name('list');

            Route::get('/get-list-of-all-trafics', 'TraficController@get_list_of_all_trafics')->name('all-trafics');

            Route::get('/find-trafic-by/{key_value}', 'TraficController@get_contrat_by')->name('show');

            Route::post('/add-new-entree', 'TraficController@store')->name('store');

            Route::post('/edit-new-entree', 'TraficController@update')->name('store');

            Route::post('/make-the-way-out', 'TraficController@makeTheWayOut')->name('mark-the-way-out');

            Route::post('/delete-new-entree', 'TraficController@delete')->name('delete');

            Route::post('/destroy-new-entree', 'TraficController@destroy')->name('destroy');
        });
    });
});
