@extends('layouts.main')

@section('content')


	<h2>Please make sure your information correct. Press the Edit button to change your info. When you're ready, fill in your credit card details to complete your purchase.</h2>

	@include('buy.partials._form_confirm')

	

	{{ Form::open(['route'=>'buy.store', 'id'=>'billing-form']) }}
	@include('buy.partials._form_stripe')

	@include('buy.partials._form_paypal')
	
	

@stop


@section('footer')
	
	{{ HTML::script("js/billing.js") }}

@stop