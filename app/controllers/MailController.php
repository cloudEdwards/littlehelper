<?php

class MailController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('contact.index');	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function send()
	{
		
        // Sanitize User Input
        $data = [];
        foreach(Input::all() as $key => $val) {
        	$data[$key]=e($val);
        }

        //Validation rules
        $rules = array (
            'first_name' => 'required|alpha',
            'last_name' => 'required|alpha',
            'phone_number'=>'numeric|min:8',
            'email' => 'required|email',
            'message' => 'required|min:25'
        );

        //Validate User Input
        $validator  = Validator::make ($data, $rules);

        // If validation passes Send Mail
        if ($validator -> passes()){

      		Mail::send('emails.hello', $data, function($message) use ($data)
            {
            	//email 'From' field: Get users email add and name
                $message->from($data['email'] , $data['first_name']);
            	//email 'To' field: cahnge this to emails that you want to be notified.                    
           	 	$message->to('kumo.cloud@gmail.com', 'Cloud')->subject('LittleHelper.Chainsaw Contact');

            });
 
            return Redirect::to('/')->withMessage('Email Sent Successfully');  
        } else{
			//return contact form with errors
            return Redirect::to('/contact')->withErrors($validator)->withInput();
        }
        
	}


}
