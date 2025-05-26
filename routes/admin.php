<?php


Route::group(['namespace' => 'App\Http\Controllers'], function(){
    Route::group(['as'=> 'admin.'], function () {
        Route::match(['GET', 'POST'],'login', 'AdminController@login')->name('login');
        
        Route::middleware('auth')->group(function () {
            Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
            Route::match(['GET', 'POST'], 'users', 'AdminController@users')->name('users');
            
            Route::match(['GET', 'POST'], 'settings', 'AdminController@settings')->name('settings');
            Route::get('logout', 'AdminController@logout')->name('logout');
            Route::match(['GET', 'POST'], 'activate/{id}', 'AdminController@activate')->name('activate');
            Route::match(['GET', 'POST'], 'suspend/{id}', 'AdminController@suspend')->name('suspend');
            Route::match(['GET', 'POST'], 'credit_user', 'AdminController@credit_user')->name('credit_user');
            Route::match(['GET', 'POST'], 'debit_user', 'AdminController@debit_user')->name('debit_user');
            Route::get('delete_user/{id}', 'AdminController@delete_user')->name('delete_user');
            Route::get('delete-users', 'AdminController@deleteUsers')->name('deleteUsers');
            Route::match(['GET', 'POST'], 'delete_users', 'AdminController@delete_users')->name('deleteUsers');
            Route::match(['GET', 'POST'], 'user_transactions/{id}', 'AdminController@user_transactions')->name('user_transactions');
            
            
            // Route::get('rever_transaction/{id}/{redirect}', 'AdminController@approve_transaction')->name('approve_transaction');
            Route::get('approve_transaction/{id}/{redirect}', 'AdminController@approve_transaction')->name('approve_transaction');
            Route::get('cancel_transaction/{id}/{redirect}', 'AdminController@cancel_transaction')->name('cancel_transaction');
            Route::get('delete_transaction/{id}/{redirect}', 'AdminController@delete_transaction')->name('delete_transaction');

            Route::get('toggle_request/{id}/{status}', 'AdminController@toggle_request')->name('toggle_request');
            Route::get('toggle_deposit/{id}/{status}', 'AdminController@toggle_deposit')->name('toggle_deposit');
            Route::get('toggle_investment/{id}/{status}', 'AdminController@toggle_investment')->name('toggle_investment');
            Route::get('delete_investment/{id}', 'AdminController@delete_investment')->name('delete_investment');
            Route::get('delete_request/{id}', 'AdminController@delete_request')->name('delete_request');
            Route::get('delete_codes/{id}/{param}', 'AdminController@delete_codes')->name('delete_codes');

            // Route::post('plans', 'Admincontroller@add_plan')->name('add_plan');
            Route::get('plans', 'Admincontroller@plans')->name('plans');
            Route::match(['GET', 'POST'], 'add_plan', 'Admincontroller@add_plan')->name('add_plan');
            Route::get('activate_plan/{id}', 'Admincontroller@activate_plan')->name('activate_plan');
            Route::get('deactivate_plan/{id}', 'Admincontroller@deactivate_plan')->name('deactivate_plan');

            Route::match(['GET', 'POST'], 'pay-profit/{id}', 'AdminController@pay_profit')->name('pay_profit');

            Route::match(['GET'], 'messages', 'AdminController@messages')->name('messages');
            Route::get('delete_message/{id}', 'AdminController@delete_message')->name('delete_message');
            Route::get('delete-messages', 'AdminController@deleteMessages')->name('deleteMessages');
            Route::match(['GET', 'POST'], 'livechat', 'AdminController@live_chat')->name('livechat');
            Route::match(['GET', 'POST'], 'payment_gateway', 'AdminController@payment_gateway')->name('payment_gateway');
            Route::match(['GET', 'POST'], 'change-password', 'AdminController@update_password')->name('change_password');
        });
    });
});
