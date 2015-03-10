<?php namespace Acme\Billing;

use Stripe;
use Stripe_Charge;
use Stripe_Customer;
use Stripe_InvalidRequestError;
use Stripe_CardError;
use Config;
use Exception;


class StripeBilling implements BillingInterface {

	public function __construct() 
	{	
		
		Stripe\Stripe::setApiKey(Config::get('stripe.secret_key'));
	}

	public function charge(array $data)
	{
		try {

			// $customer = Stripe\Customer::create([
			// 		'card'=>$data['card'],
			// 		'description'=>$data['email']
			// 	]);

			Stripe\Charge::create([
			'amount'=>1300,  // $100  DONT RELY ON FORM DATA
			'currency'=> 'cad',
			'description'=> $data['email'],
			'card'=>$data['card']
			//,'customer'=>$customer
			]);

			//return $customer->id;
			
		} catch (Stripe_CardError $e) {
			
			throw new Exception($e->getMessage());
		}
		catch (Stripe_InvalidRequestError $e) {
			
			throw new Exception($e->getMessage());
		}
		catch (Exception $e) {
			
			throw new Exception($e->getMessage());
		}
		catch (Stripe_CardError $e) {
			
			throw new Exception($e->getMessage());
		}
	}

}

