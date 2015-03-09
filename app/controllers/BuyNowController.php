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
	public function store()
	{
		$rules = array(
			'quantity'=> ['required', 'numeric'], 
			'first-name'=>'required|alpha',
			'last-name'=>'required|alpha',
			'phone-number'=> ['required', 'min:10'], 
			'email'=> ['required', 'email'], 
			'address'=>'required',
			'province'=> 'required|alpha', 
			'country'=>'required|alpha',
			'postal-code'=> ['required', 'min:6']
		 );

		$input = Input::all();

		$validator= Validator::make($input, $rules);

		if ($validator->fails()) {
			return Redirect::route('buy.index')->withErrors($validator->messages())->withInput($input);
		}
		return View::make('buy/create')->withData($input);
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
