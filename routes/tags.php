<?php
use Illuminate\Support\Facades\Route;

Route::group(
    ['middleware' => ['can:view tags']],
    function () {
        Route::get('tags/search', 'TagController@search')->name('tags.search');
        Route::get('tags/{tag}/show', 'TagController@show')->name('tags.show');

        Route::resource('tags', 'TagController', [
            'only' => ['store', 'update', 'destroy'],
        ]);
    }
);
