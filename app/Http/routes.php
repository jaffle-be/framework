<?php

Route::get('/', [
    'uses' => 'WelcomeController@index',
    'as' => 'home'
]);

Route::get('/start', [
    'uses' => 'WelcomeController@start',
    'as' => 'start'
]);