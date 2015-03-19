<?php
 /**
 * Sample code for the GetRates Canada Post service.
 * 
 * The GetRates service returns a list of shipping services, prices and transit times 
 * for a given item to be shipped. 
 *
 * This sample is configured to access the Developer Program sandbox environment. 
 * Use your development key username and password for the web service credentials.
 * 
 **/

// Your username, password and customer number are imported from the following file    	
// CPCWS_Rating_PHP_Samples\REST\rating\user.ini 

namespace tools\Shipping\CanPostAPI\REST\rating\GetRates;


	class GetRates implements \tools\Shipping\ShippingInterface {

		public function getRates($zipCode, $quantity){


			//$userProperties = $_ENV['CANPOST_SECRET'];

			$username = $_ENV['CANPOST_USER']; 
			$password = $_ENV['CANPOST_PASSWORD'];
			$mailedBy = $_ENV['CANPOST_CUSTNUM'];

			// REST URL
			$service_url = 'https://ct.soa-gw.canadapost.ca/rs/ship/price';

			// Create GetRates request xml
			$originPostalCode = 'V1L4E7'; 
			$postalCode = $zipCode;
			//'B3J1S3'  Halifax
			$weight = 0.7 * $quantity;

			if($quantity > 2){
				if($quantity >=5 or $quantity <=10){
					// 5 - 10
					$length = 48;
					$width = 48;
					$height = 42;
				}

				else {
					// 3 or 4
					$length = 48;
					$width = 32;
					$height = 28;
				}
			}
			else{
				// 1 or 2
				$length = 48;
				$width = 16;
				$height = 14;
			}
			

$xmlRequest = <<<XML
<?xml version="1.0" encoding="UTF-8"?>
	<mailing-scenario xmlns="http://www.canadapost.ca/ws/ship/rate-v3">
	  <!-- <customer-number>{$mailedBy}</customer-number> -->
	  <quote-type>counter</quote-type>
	  <parcel-characteristics>
	    <weight>{$weight}</weight>
	    <dimensions>
		  	<length>{$length}</length>
		    <width>{$width}</width>
		    <height>{$height}</height>
	  	</dimensions>
	  </parcel-characteristics>
	  <services>
	  	<service-code>DOM.RP</service-code>
	  </services>
	  <origin-postal-code>{$originPostalCode}</origin-postal-code>
	  <destination>
	    <domestic>
	      <postal-code>{$postalCode}</postal-code>
	    </domestic>
	  </destination>
	</mailing-scenario>
XML;

			$curl = curl_init($service_url); // Create REST Request
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
			curl_setopt($curl, CURLOPT_CAINFO, realpath(dirname($_SERVER['SCRIPT_FILENAME'])) . '/cert/cacert.pem');
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlRequest);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($curl, CURLOPT_USERPWD, $username . ':' . $password);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/vnd.cpc.ship.rate-v3+xml', 'Accept: application/vnd.cpc.ship.rate-v3+xml'));
			$curl_response = curl_exec($curl); // Execute REST Request
			if(curl_errno($curl)){
				return 'Curl error: ' . curl_error($curl) . "\n";
			}

			$response = 'HTTP Response Status: ' . curl_getinfo($curl,CURLINFO_HTTP_CODE) . "\n";

			curl_close($curl);

			// Example of using SimpleXML to parse xml response
			libxml_use_internal_errors(true);
			$xml = simplexml_load_string('<root>' . preg_replace('/<\?xml.*\?>/','',$curl_response) . '</root>');
			//out put variable to be returned as array
			$output = [];

			if (!$xml) {
				echo 'Failed loading XML' . "\n";
				echo $curl_response . "\n";
				foreach(libxml_get_errors() as $error) {
					echo "\t" . $error->message;
				}
			} else {
				if ($xml->{'price-quotes'} ) {
					$priceQuotes = $xml->{'price-quotes'}->children('http://www.canadapost.ca/ws/ship/rate-v3');
					if ( $priceQuotes->{'price-quote'} ) {
						foreach ( $priceQuotes as $priceQuote ) { 
							$output[]= [
								$priceQuote->{'service-name'},
								$priceQuote->{'price-details'}->{'due'}
							];	
						}
						return $output;
					}
				}
				if ($xml->{'messages'} ) {					
					$messages = $xml->{'messages'}->children('http://www.canadapost.ca/ws/messages');		
					foreach ( $messages as $message ) {
						echo 'Error Code: ' . $message->code . "\n";
						echo 'Error Msg: ' . $message->description . "\n\n";
					}
				}
					
		}
	}


}
?>

