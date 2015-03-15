<?php namespace tools\Providers;


use Illuminate\Support\ServiceProvider;

class BillingServiceProvider extends ServiceProvider {
	
	public function register() 
	{
		$this->app->bind(
			'tools\Billing\BillingInterface', 
			'tools\Billing\PaypalBilling');

	}
}