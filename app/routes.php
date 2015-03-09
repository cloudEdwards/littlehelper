<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
//Home Page
Route::get('/', 'LittleHelperController@index');

//Buy Now Page
Route::resource('/buy', 'BuyNowController');

// About Page
Route::get('/about', 'LittleHelperController@about');

//Contact Page
Route::get('/contact', 'ContactController@getContact');
 
//Form request:: POST action will trigger to controller
Route::post('/contact_request','ContactController@getContactUsForm');