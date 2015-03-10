@extends('layouts.main')

@section('content')


        {{{ var_dump($output) }}}


	<h3>Payment recieved, your order has been placed. Thank You!</h3>

@stop


@section('footer')
	
	{{ HTML::script("js/billing.js") }}

@stop