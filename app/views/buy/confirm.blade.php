@extends('layouts.main')

@section('content')

        <div class="textblock">
        	<p>Please Confirm Your Order</p>
		</div>

		@include('buy.partials._form_confirm')
@stop


@section('footer')
	
	{{ HTML::script("js/billing.js") }}

@stop