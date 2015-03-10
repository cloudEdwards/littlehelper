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
Route::resource('/', 'LittleHelperController');

//Buy Now Page
Route::resource('/buy', 'BuyNowController');

//Contact Page
Route::resource('/contact', 'MailController');


// About Page
Route::get('/about', 'LittleHelperController@about');
