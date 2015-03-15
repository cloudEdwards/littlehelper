@extends('layouts.main')

@section('content')

        <div class="textblock">
        	<p>Payment recieved, your order has been placed. Thank You!</p>
		</div>
	
@stop


@section('footer')
	
	{{ HTML::script("js/billing.js") }}

@stop