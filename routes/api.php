<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JWTVerify;
use Illuminate\Support\Facades\Broadcast;
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
/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Laravel API Documentation",
 *      description="L5 Swagger OpenAPI description",
 *      @OA\Contact(
 *          email="admin@admin.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Demo API Server"
 * )
 */

Route::group(['namespace' => 'App\Http\Controllers'], function() {
    /**
    * @OA\PathItem(
    *     path="/v1"
    * )
    */
    Route::group(['as'=> 'api.'], function () {
        Route::post('register', 'AuthController@register')->name('register');
        Route::post('login', 'AuthController@login')->name('login');
        Route::post('forgot-password', 'AuthController@forgot_password')->name('forgot_password');
        Route::post('reset-password', 'AuthController@reset_password')->name('reset_password');
        

        // Authenticated Routes
        Route::middleware(['auth:sanctum'])->group(function () {
            // Route::get('refresh_token', 'AuthController@refresh')->name('refresh');
            // Route::match(['GET', 'POST'], 'revoke_token', 'AuthController@revoke_token')->name('logout');
            Route::get('user', 'AuthController@user');

            
            // Route::get('recent_transactions', 'ServicesController@recent_transactions')->name('recent_transactions');

            // // Account Service
            // Route::get('wallet_balance', 'AccountController@wallet_balance')->name('wallet_balance');
            // Route::post('update_password', 'AccountController@update_password')->name('update_password');
            // Route::post('update_profile', 'AccountController@update_profile')->name('update_profile');
            // Route::get('get_profile', 'AccountController@get_profile')->name('get_profile'); 

            Route::middleware(['role:admin'])->group(function() {
                Route::post('add_category', 'AdminController@add_category')->name('add_product_category');
                Route::get('get_categories', 'AdminController@get_categories');
                Route::post('delete_category', 'AdminController@delete_category');
            });
        });
    })->middleware(\App\Http\Middleware\Cors::class);
});