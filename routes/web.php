<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@landing')->name('landing');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/flower/current', 'HomeController@flower')->name('flower')->middleware('auth');

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/prototype', 'PrototypeController@index')->name('prototype');
    Route::get('/prototype/users/{id}', 'PrototypeController@showUser');
    Route::post('/prototype/create-users', 'PrototypeController@createUsers');
    Route::post('/prototype/assign-users', 'PrototypeController@assignUsers');
    Route::post('/prototype/reset-database', 'PrototypeController@resetDatabase');

    // Admin panel
    Route::group(['prefix' => 'admin'], function () {
        Route::redirect('/', '/admin/maintenance')->name('admin');
        Route::get('/maintenance', 'AdminController@maintenance')->name('admin.maintenance');
        Route::post('/maintenance', 'AdminController@toggleMaintenance')->name('admin.maintenance.toggle');
        Route::get('/users', 'AdminController@users')->name('admin.users');
        Route::get('/payments', 'AdminController@payments')->name('admin.payments');

        Route::get('/flower/{id}', 'HomeController@flower');
    });
});

Route::group(['middleware' => ['auth']], function() {
    Route::get('/payment/app', 'PaymentController@appPayment')->name('payments.app');
    Route::get('/payment/fire', 'PaymentController@firePayment')->name('payments.fire');
    Route::post('/payment', 'PaymentController@processPayment')->name('payments.process');
    Route::get('/payment/subscription', 'PaymentController@appSubscripton')->name('payments.subscription');
    Route::post('/create-checkout-session', 'PaymentController@createCheckoutSession')->name('payments.createCheckoutSession');
});

Route::get('/contact', 'HomeController@contact')->name('contact');
Route::post('/contact', 'HomeController@processContact')->name('contact.process');