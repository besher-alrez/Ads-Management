<?php
use Illuminate\Support\Facades\Route;

Route::group(
    ['middleware' => ['can:view ads']],
    function () {
        Route::get('ads/search', 'AdController@search')->name('ads.search');
        Route::get('ads/{ad}/show', 'AdController@show')->name('ads.show');

        Route::resource('ads', 'AdController', [
            'only' => ['store', 'update', 'destroy'],
        ]);
    }
);
