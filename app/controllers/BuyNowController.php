<?php

use BillingLog;
use Prices;

class BuyNowController extends \BaseController {


	// protects site from cross site forgery
	public function __construct() {

		$this->beforeFilter('csrf', array ('on'=>['post','put', 'delete']));
	}

	/**
	 * Display a listing of form to 
	 * input Shipping and purchase info.
	 *
	 * @return Form for ordering
	 */
	public function index()
	{
		return View::make('buy/index');
	}


	/**
	 * Display the shipping info input from User  
	 * Allows User to confirm or edit shipping info
	 * Shows purchase info:
	 * tax, shipping and total
	 *
	 * @return Confirm page
	 */
	public function confirm()
	{
		$rules = array(
			'quantity'=> ['required', 'numeric'], 
			'first-name'=>'required|alpha',
			'last-name'=>'required|alpha',
			'phone-number'=> ['required', 'min:10'], 
			'city'=> ['required', 'alpha'], 
			'address'=>'required',
			'province'=> 'required|alpha', 
			'country'=>'required|alpha',
			'postal-code'=> ['required', 'alpha_num', 'min:6']
		 );

		$input = Input::all();
		$input['postal-code']= strtoupper(preg_replace('/\s+/', "", 
								$input['postal-code']));

		$validator= Validator::make($input, $rules);

		if ($validator->fails()) {
			return Redirect::route('buy.index')->withErrors($validator->messages())->withInput($input);
		}

		$shipping = App::make('tools\Shipping\ShippingInterface');
		$rates = $shipping->getRates($input['postal-code'],$input['quantity']);

		$invoiceHash = Hash::make('secret');

		$price = Prices::findOrFail(1)['attributes']['price'];
		$subTotal = $price * $input['quantity'];
		$tax = $subTotal * 0.12;

		$bill = new BillingLog();
		$bill->id= $invoiceHash;
		$bill->shipping=$rates[0][1];
		$bill->quantity=$input['quantity'];
		$bill->tax= $tax;
		$bill->amount= $subTotal + $rates[0][1] + $tax;
		$bill->name=$input['first-name'].' '.$input['middle-name'].' '.$input['last-name'];
		$bill->phonenumber=$input['phone-number'];
		$bill->email=$input['email'];
		$bill->address= $input['address'].' - '.$input['apt'].' '.$input['pobox'].' '.$input['rr'];
		$bill->city=$input['city'];
		$bill->province=$input['province'];
		$bill->country=$input['country'];
		$bill->postalcode=$input['postal-code'];

		$bill->save();


		return View::make('buy.confirm')
			->withData($input)
			->withShippingRates($rates)
			->withHash($invoiceHash)
			->withTax($tax);
	}


	/**
	 * Sends Request to Paypal for a payKey
	 * Recieves payKey and redirects to a url
	 * with the payKey as a GET variable
	 *
	 * @return Redirects to PayPal checkout
	 */
	public function checkout()
	{
		$input = Input::all();

		$result = App::make('tools\Billing\BillingInterface');

		$result = $result->charge(['hash'=>$input['hash']]);

		$url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_ap-payment&paykey='
				.$result['payKey'];

		return Redirect::to($url);
	}


	/**
	 * Upon Completed Purchase, Paypal returns to this url
	 * With a Hash ID for the completed transaction
	 * Transaction is marked completed in DB
	 * Then emails and text messages are sent 
	 * to both buyer and seller
	 * containing the invoices for the transaction 
	 *
	 * @return Complete page
	 */
	public function complete()
	{	

		$hash = Input::get('hash');
		$order = BillingLog::findOrFail($hash);
		$order->completed = 'true';
		$order->save();

		$confirmed_bill=$order['attributes'];
		$email = $confirmed_bill['email'];
		// !!!*!*!*!****!*!Replace with Angels Email
		$shopEmail = 'kumo.cloud@gmail.com';
		
		// Send Customer Invoice
		Mail::send('emails.invoice', ['invoice'=>$confirmed_bill], function($message) use ($email)
			{
			    $message->to($email, 'Cloud')->subject('Thank You!');
			});
		// Send Order to Manufacturer
		Mail::send('emails.order', ['invoice'=>$confirmed_bill], function($message)  use ($shopEmail)
			{
			    $message->to($shopEmail, 'Cloud')->subject('New Order!');
			});

		// Send Text Message

		$account_sid = 'ACb6f468752fecc4eb3ebf70648b71e347'; 
		$auth_token = '4575f860099381b42b4a60bcac14f84f'; 
		$client = new Services_Twilio($account_sid, $auth_token); 
		 
		$client->account->messages->create(array( 
			'To' => "12503543711", 
			'From' => "+13345641913", 
			'Body' => "You have a New Order from LittleHelper.Chainsaw, check your email.",   
		));

		return View::make('buy/complete');
	}



	/*  Method for Stripe Billing
	/**
	 * Store a newly created resource in storage.
	 *
	 *@param hash  -  uniqure hash code to id each transaction
	 *
	 *@return complete page
	 *
	 */
	/*
	public function store()
		{
			$input = Input::all();

			
			$billing = App::make('tools\Billing\BillingInterface');

			$confirmed_bill = $billing->charge( [
				'email'=> Input::get('email'),
				'card'=> Input::get('stripe-token'),
				'hash'=> Input::get('hash')
			]); 
			
			$order = $confirmed_bill['order'];
			$email = $order['email'];
			$msg = "Hello ";

			// Send Customer Invoice
			Mail::send('emails.invoice', ['invoice'=>$confirmed_bill], function($message) use ($email)
				{
				    $message->to($email, 'Cloud')->subject('Thank You!');
				});
			// Send Order to Manufacturer
			Mail::send('emails.order', ['invoice'=>$confirmed_bill], function($message)  use ($email)
				{
				    $message->to($email, 'Cloud')->subject('New Order!');
				});

			// Send Text Message

			$account_sid = 'ACb6f468752fecc4eb3ebf70648b71e347'; 
			$auth_token = '4575f860099381b42b4a60bcac14f84f'; 
			$client = new Services_Twilio($account_sid, $auth_token); 
			 
			$client->account->messages->create(array( 
				'To' => "12503543711", 
				'From' => "+13345641913", 
				'Body' => "You have a New Order from LittleHelper.Chainsaw, check your email.",   
			));


			return View::make('buy/complete')->withOutput($confirmed_bill);
		}*/



}
