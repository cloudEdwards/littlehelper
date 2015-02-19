<?php
class BuyNowController extends BaseController {
 
//Shows the Buy Now form
 public function buyNow(){
 
            return View::make('buy.index');
        }



//Gets the Buy Now Form inputs
 public function getBuyNowForm(){

	//TODO Validate Form input 
 	//   and calculate price w/ shipping.
 	// Show confirmation page, 
 	// confirmation page leads to check out 
 
            return View::make('buy.index');
        }

}

?>