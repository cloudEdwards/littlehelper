<?php


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
	 * @return Response
	 */

	// bind the interface to the stripe billing class 
	
	

	public function store()
	{

		$input = Input::all();

		//return View::make('buy/create')->withStripeToken($input);
		
		$billing = App::make('Acme\Billing\BillingInterface');

		$confirmed_bill = $billing->charge( [
			'email'=> Input::get('email'),
			'card'=> Input::get('stripe-token')
			]); 

		return View::make('buy/confirm')->withOutput($confirmed_bill);
	
	}
	

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
