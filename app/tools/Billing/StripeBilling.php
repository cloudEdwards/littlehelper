<?php namespace tools\Billing;

use Stripe;
use Stripe_Charge;
use Stripe_Customer;
use Stripe_InvalidRequestError;
use Stripe_CardError;
use Config;
use Exception;
use BillingLog;
use Prices;


class StripeBilling implements BillingInterface {

	public function __construct() 
	{	
		
		Stripe\Stripe::setApiKey(Config::get('stripe.secret_key'));
	}

	public function charge(array $data)
	{
		try {

			$order = BillingLog::findOrFail($data['hash']);

			$orderList= $order['attributes'];

			$price = Prices::findOrFail(1);
			$price = $price['attributes']['price'];
			$price = intval($price * 100);
			$shipping = intval($orderList['shipping'] *100);
			$total = intval(($price * $orderList['quantity']) 
				+ $shipping);
			// $customer = Stripe\Customer::create([
			// 		'card'=>$data['card'],
			// 		'description'=>$data['email']
			// 	]);

			Stripe\Charge::create([
			'amount'=>$total, 
			'currency'=> 'cad',
			'description'=> $data['email'],
			'card'=>$data['card']
			//,'customer'=>$customer
			]);

			$order->completed='true';
			$order->save();
			$order = BillingLog::findOrFail($data['hash'])['attributes'];

			return [
				'data'=>$data,
				'order'=>$order,
				'price'=>$price,
				'total'=>$total
				];   
			
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

