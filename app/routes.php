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


// Home Page
Route::get('/', 'BaseController@index');


//Contact Page
Route::resource('/contact', 'MailController',['except'=>[
	'create','show','edit','update','destroy']
	]);


//Buy Now Page
Route::resource('/buy', 'BuyNowController', ['except'=>[
	'show','edit','destroy']
	]);

// Confirm Order
Route::post('/buy/confirm', ['as'=>'buy.confirm', 
	'uses'=>'BuyNowController@confirm']);

// Charge Card
Route::post('/buy/checkout', ['as'=>'buy.checkout', 
	'uses'=>'BuyNowController@paypal']);

// Successful Order
Route::post('/buy/success', ['as'=>'buy.success', 
	'uses'=>'BuyNowController@success']);


