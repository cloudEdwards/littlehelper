@extends('layouts.main')

@section('content')


	<h2>Finalize Order</h2>

	@include('buy.partials._form_creditcard')

@stop


@section('footer')
	
	{{ HTML::script("js/billing.js") }}

@stop