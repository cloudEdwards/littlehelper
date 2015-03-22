<?php

use BillingLog;
use Prices;

class BuyNowController extends \BaseController {


	// protects site from cross site forgery
	public function __construct() {

		$this->beforeFilter('csrf', array ('on'=>['post','put', 'delete']));
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('buy/index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{	
		return View::make('buy/create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @ Response
	 *@param hash
	 */

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
	
	}

		/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function complete()
	{	
		return View::make('buy/complete');
	}


	/**
	 * Display the specified resource.
	 *
	 * @return Response
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
		$bill->amount= $subTotal + $rates[0][1];
		$bill->name=$input['first-name'].' '.$input['middle-name'].' '.$input['last-name'];
		$bill->phonenumber=$input['phone-number'];
		$bill->email=$input['email'];
		$bill->address= $input['address'].' - '.$input['apt'].' '.$input['pobox'].' '.$input['rr'];
		$bill->city=$input['city'];
		$bill->province=$input['province'];
		$bill->country=$input['country'];
		$bill->postalcode=$input['postal-code'];

		$bill->save();


		return View::make('buy.create')
			->withData($input)
			->withShippingRates($rates)
			->withHash($invoiceHash)
			->withTax($tax);
	}

		/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function paypal()
	{
		$input = Input::all();

		$result = App::make('tools\Billing\BillingInterface');

		$result = $result->charge(['hash'=>$input['hash']]);

		$url = 'https://www.sandbox.paypal.com/cgi-bin/webscr?cmd=_ap-payment&paykey='
				.$result['payKey'];

//  Send Invoicing correspondance
		$order = BillingLog::findOrFail($input['hash'])['attributes'];
		$price = Prices::findOrFail(1);

		$confirmed_bill = [
				'data'=>$input,
				'order'=>$order,
				'price'=>$result['price'],
				'total'=>$result['total']
				];
		
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

		return Redirect::to($url);
		//return View::make('buy/paypal')->withUrl($url);
	}



}
