<?php



// THIS SCRIPT IS NOT BEING USED

// ONLY FOR FUTURE REFERENCE IN THIS PROJECT





	/*	 * Store a newly created resource in storage.
	 *
	 *@param hash  -  uniqure hash code to id each transaction
	 *
	 *@return complete page
	 *
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
