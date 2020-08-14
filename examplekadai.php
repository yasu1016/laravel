<?php

Route::group(['prefix' => 'admin'], function () {
    Route::get('aaa/bbb', 'AAAController@bbb');
});
