<?php

Route::get('/lang/{lang}', 'LangController@index');
Route::get('/','LangController@login');
Route::post('/','LangController@loged');
Route::get('/logout','LangController@logout');

Route::get('/home','LangController@home')->middleware('admin');
Route::get('{any}', 'LangController@home')->where('any', '([A-z\d\-\/_.]+)');
