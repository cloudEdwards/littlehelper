@extends('layouts.main')

@section('content')

		@include('buy.partials._form_confirm')

    
@stop

@section('footer')
	
	{{ HTML::script("js/billing.js") }}

@stop