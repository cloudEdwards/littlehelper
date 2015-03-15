<?php namespace tools\Providers;


use Illuminate\Support\ServiceProvider;

class ShippingServiceProvider extends ServiceProvider {
	
	public function register() 
	{
		$this->app->bind(
			'tools\Shipping\ShippingInterface',
		 	'tools\Shipping\CanPostAPI\REST\rating\GetRates\GetRates');
		
	}
}