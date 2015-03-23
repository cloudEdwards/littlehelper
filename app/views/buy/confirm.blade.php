@extends('layouts.main')

@section('content')


	<div class="textblock">
		<p>
			<strong>Please make sure your information is correct. Press the Edit button to change your info. When you're ready, Press the Purchase button to get your chainsaw</strong>
		</p>

	@include('buy.partials._form_confirm')

	{{Form::open(['route'=>'buy.checkout'])}}
	{{Form::hidden('hash', $hash)}}
	{{Form::submit('Purchase', ['class'=>'button big'])}}
	{{Form::close()}}
		
	</div> 	

@stop

@section('footer')
	
	<!-- Javascript for Stripe {{ HTML::script("js/billing.js") }} -->

@stop