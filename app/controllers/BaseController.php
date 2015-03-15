<?php

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
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return View::make('hello');
	}



	/**
	 * Display the About page
	 *
	 * @return Response
	 */
	public function ourStory()
	{
		return View::make('ourstory.index');
	}
	

}
