<?php

Route::get('/', [
    'uses' => 'WelcomeController@index',
    'as' => 'home'
]);

Route::get('admin', [
    'uses' => 'WelcomeController@start',
    'as' => 'start'
]);

Route::get('test', 'WelcomeController@test');
Route::get('test2', 'WelcomeController@test2');