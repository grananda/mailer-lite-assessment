<?php

use Illuminate\Support\Facades\Route;

Route::get('accounts', 'AccountController@index')->name('api.account.index');
Route::get('accounts/{id}', 'AccountController@show')->name('api.account.show');

Route::get('accounts/{id}/transactions', 'TransactionController@index')->name('api.transaction.index');
Route::post('accounts/{id}/transactions', 'TransactionController@store')->name('api.transaction.store');

Route::get('currencies', 'CurrencyController@index')->name('api.currency.index');
