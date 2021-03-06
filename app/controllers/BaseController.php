<?php

use Prices;

class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}


	/**
	 * Display a listing of the Home Page.
	 *
	 * @return makes Home page
	 */
	public function index()
	{
		$price = Prices::findOrFail(1);
		return View::make('hello')->withPrice($price->price);
	}


}
