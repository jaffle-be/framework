<?php

Route::group(['namespace' => 'App\Contact\Http'], function () {
    Route::resource('contact', 'ContactController', ['only' => ['index']]);
});