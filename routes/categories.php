<?php
use Illuminate\Support\Facades\Route;

Route::group(
    ['middleware' => ['can:view categories']],
    function () {
        Route::get('categories/search', 'CategoryController@search')->name('categories.search');
        Route::get('categories/{category}/show', 'CategoryController@show')->name('categories.show');

        Route::resource('categories', 'CategoryController', [
            'only' => ['store', 'update', 'destroy'],
        ]);
    }
);
