<?php

// api.php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/product/create', 'ProductController@store');
Route::get('/product/edit/{id}', 'ProductController@edit');
Route::post('/product/update/{id}', 'ProductController@update');
Route::delete('/product/delete/{id}', 'ProductController@delete');
Route::get('/products', 'ProductController@index');
Route::get('/ExportProduct' , 'ProductController@ExportProduct');