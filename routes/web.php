<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\App;
use App\Utils\Meta;

Route::group(['namespace' => 'App\Http\Controllers'], function(){

    Route::get('/auth/email/verification-status/{email}', 'AuthController@showVerification')->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', 'AuthController@verify')->name('verification.verify');
    Route::get('/email/resend/{email}', 'AuthController@resend_verification')->middleware(['throttle:6,1'])->name('verification.send');
    
    Route::group(['as'=> 'web.'], function () {
        
        Route::get('/auth/reset-password/{email}/{token}', 'AuthController@showResetForm')->name('reset_password');
        Route::get('/auth/reset-failed', 'Controller@showVueRoute')->name('reset_failed');
        Route::get('/auth/verification-failed', 'Controller@showVueRoute')->name('verification_failed');
        Route::get('/auth/verification-success', 'Controller@showVueRoute')->name('verification_success');
        
        Route::get("/{name}", 'Controller@showVueRoute')->whereIn('name', ['auth', 'account']);
        Route::get("/{path}", "Controller@showVueRoute")->where('path', '.+');
    });

    Route::fallback('Controller@showVueRoute');
});

Route::fallback('\App\Http\Controllers\Controller@showVueRoute');

