<?php namespace tools\Billing;

use BillingLog;
use Prices;

class PaypalBilling implements BillingInterface 
{

	public function charge(array $data)
	{

		$order = BillingLog::findOrFail($data['hash']);

		$orderList= $order['attributes'];

		$price = Prices::findOrFail(1);
		$price = $price['attributes']['price'];
		$price = intval($price * 100);
		$shipping = intval($orderList['shipping'] *100);
		$totalCents = intval(($price * $orderList['quantity']) 
			+ $shipping);
		$total = $totalCents / 100;

		$dataLoad = array(
			"actionType"=>"PAY",    // Specify the payment action
			"currencyCode"=>"CAD",  // The currency of the payment
			"receiverList"=>[
				"receiver"=>[
					"amount"=>$total, // The payment amount
					"email"=>"kumo.cloud@gmail.com" // The payment Receiver's email address
				]  
			],

			// Where the Sender is redirected to after approving a successful payment
			"returnUrl"=>"http://littlehelper.chainsaw:8000/about",

			// Where the Sender is redirected to upon a canceled payment
			"cancelUrl"=>"http://littlehelper.chainsaw:8000/contact",
			"requestEnvelope"=>[
				"errorLanguage"=>"en_US",    // Language used to display errors
				"detailLevel"=>"ReturnAll"   // Error detail level
			]
		);

		$data_string = json_encode($dataLoad);                                                                                   
		 
		$ch = curl_init('https://svcs.sandbox.paypal.com/AdaptivePayments/Pay');                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(   
			'Content-Type: application/json',                                                                                
			'Content-Length: '. strlen($data_string),
			// Sandbox API credentials for the API Caller account                                                       
			'X-PAYPAL-SECURITY-USERID : kumo.cloud_api1.gmail.com',
			'X-PAYPAL-SECURITY-PASSWORD : E887SPW9F5XZ9ZZ8',
			'X-PAYPAL-SECURITY-SIGNATURE : AFcWxV21C7fd0v3bYYYRCpSSRl31AHoNvoOZH-4m-9gpLxgk7Ab0MYTJ',
			// Global Sandbox Application ID
			'X-PAYPAL-APPLICATION-ID : APP-80W284485P519543T',
			// Input and output formats
			'X-PAYPAL-REQUEST-DATA-FORMAT : JSON',
			'X-PAYPAL-RESPONSE-DATA-FORMAT : JSON ')                                                                      
		);                                                                                                                   

		$resultJson = curl_exec($ch);
		$output = json_decode($resultJson);
		$payKey = $output->payKey;
		return $payKey;
	}
}

?>