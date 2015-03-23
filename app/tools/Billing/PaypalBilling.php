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
		$price = number_format(floatval($price),2);
		$shipping = number_format(floatval($orderList['shipping']),2);
		$tax = number_format(floatval($orderList['tax']),2);
		$subTotal = number_format(floatval(($price * $orderList['quantity'])),2);
		$total = $subTotal + $shipping + $tax;
	

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
			"returnUrl"=>"http://www.littlehelpersaws.com/buy/complete?hash=".
			$data['hash'],

			// Where the Sender is redirected to upon a canceled payment
			"cancelUrl"=>"http://www.littlehelpersaws.com",
			"requestEnvelope"=>[
				"errorLanguage"=>"en_US",    // Language used to display errors
				"detailLevel"=>"ReturnAll"   // Error detail level
			]
		);

		$data_string = json_encode($dataLoad);                                                                                   
		 
		$ch = curl_init('https://svcs.paypal.com/AdaptivePayments/Pay');                                                                      
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      

		curl_setopt($ch, CURLOPT_HTTPHEADER, array(   
			'Content-Type: application/json',                                                                                
			'Content-Length: '. strlen($data_string),
			// Sandbox API credentials for the API Caller account                                                       
			'X-PAYPAL-SECURITY-USERID : littlehelpersaws_api1.gmail.com',
			'X-PAYPAL-SECURITY-PASSWORD : ZKJZZC35WM46QCAF',
			'X-PAYPAL-SECURITY-SIGNATURE : A7ErME.S7jXxqqfj1NWlnWs.56bKAIrMK0mJAalRt4taiBWH6uD0Gwy2',
			// Global Sandbox Application ID
			'X-PAYPAL-APPLICATION-ID : APP-1NM59315J2128684U',
			// Input and output formats
			'X-PAYPAL-REQUEST-DATA-FORMAT : JSON',
			'X-PAYPAL-RESPONSE-DATA-FORMAT : JSON ')                                                                      
		);                                                                                                                   

		$resultJson = curl_exec($ch);
		$output = json_decode($resultJson);
		
		$payKey = $output->payKey;

		return [
			'payKey'=>$payKey,
			'price'=>$price,
			'shipping'=>$shipping,
			'total'=>$total
		];
	}
}

?>