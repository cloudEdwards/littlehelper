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
	 * Displays the User Input: Shipping Address.  
	 * Allows User to confirm or edit shipping info
	 * Shows purchase amounts:
	 * Tax, shipping and total charge.
	 *
	 * @return Confirm page
	 */
	public function confirm()
	{
		// Validation Rules
		$rules = array(
			'quantity'=> ['required', 'numeric'], 
			'first-name'=>'required|alpha',
			'last-name'=>'required|alpha',
			'phone-number'=> ['required', 'min:10'], 
			'city'=> ['required', 'alpha'], 
			'address'=>'required',
			'province'=> 'required', 
			'country'=>'required',
			'postal-code'=> ['required', 'alpha_num', 'min:6']
		 );

		// Sanitize User Input
		$input = [];
		foreach(Input::all() as $key=>$val) {
			$input[$key]= e($val);
		} 

		// Converts to Valid Postal Code
		$input['postal-code']= 
			strtoupper(preg_replace(
				'/\s+/', "", $input['postal-code']));
		
		// Validate User Input
		$validator= Validator::make($input, $rules);

		if ($validator->fails()) {
			return Redirect::route('buy.index')->withErrors($validator->messages())->withInput($input);
		}

		// Instantiate Canada Post API Object
		$shipping = App::make('tools\Shipping\ShippingInterface');
		
		// Calculate Shipping Rates with Postal Code 
		$rates = $shipping->getRates($input['postal-code'],$input['quantity']);

		// *** Generate Unique Id for this transaction		
		// Generate Random Number as String
		$rand = (string) rand(1000,9999);
		// Create Hash Code and take a substring.
		$hashCode = substr(Hash::make('secret'),-4,4);
		// Join number and hash to make 8 digit code
		$invoiceHash = $hashCode.$rand;
		// Get price from database
		$price = Prices::findOrFail(1)['attributes']['price'];
		// Multiply by quantity
		$subTotal = $price * $input['quantity'];
		// Sales Tax at 12%
		$tax = $subTotal * 0.12;

		// Billing Log Model for DB
		// Add values and save to database
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
		// Sanitize User Input
		$input = [];
		foreach(Input::all() as $key=>$val) {
			$input[$key]= $val;
		}

		// Instantiate PayPal API 
		$result = App::make('tools\Billing\BillingInterface');
		
		// Make Request to PayPal API
		// Passes the transaction ID to pull
		// the transaction info. from the database
		// Returns a Pay Key to point to PayPal transaction
		$result = $result->charge(['hash'=>$input['hash']]);

		// Append the Pay Key to the PayPal End Point
		$url = 'https://www.paypal.com/cgi-bin/webscr?cmd=_ap-payment&paykey='
				.$result['payKey'];

		// Redirect Client to PayPal for Checkout		
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
		// Get transaction ID returning from PayPal
		$hash = e(Input::get('hash'));
		// Find Transaction details from Database
		$order = BillingLog::findOrFail($hash);
		// Confirm Transation has been compleated
		$order->completed = 'true';

		$order->save();

		// Get Customer Email from database
		$confirmed_bill=$order['attributes'];
		$email = $confirmed_bill['email'];
		
		// Manufacturers Email  and Phone
		$shopEmail = 'angelheartsongs@gmail.com';
		$shopPhone = '12505090543';

		// Send Customer an Invoice
		Mail::send('emails.invoice', ['invoice'=>$confirmed_bill], function($message) use ($email)
			{
			    $message->to($email, 'Cloud')->subject('Thank You!');
			});

		// Send Order to Manufacturer
		Mail::send('emails.order', ['invoice'=>$confirmed_bill], function($message)  use ($shopEmail)
			{
			    $message->to($shopEmail, 'Cloud')->subject('New Order!');
			});

		// Send Text Message to Maufacturer
		$account_sid = $_ENV['TWILIO_ID']; 
		$auth_token = $_ENV['TWILIO_AUTH']; 
		$client = new Services_Twilio($account_sid, $auth_token); 
		 
		$client->account->messages->create(array( 
			'To' => $shopPhone, 
			'From' => "+13345641913", 
			'Body' => "You have a New Order from LittleHelper.Chainsaw, check your email.",   
		));

		// Takes Client to Thank You page
		return View::make('buy/complete');
	}


}
