{{ Form::open(['route'=>'buy.store', 'id'=>'billing-form']) }}

<div class="textblock">
	<p>To safely complete your purchase;</p>
	<p>Use Stripe.</p>
</div>

<div class="payment-errors error"></div>

<div class="forms credit">
	<label id="cardno">
		<span >Card Number:</span>
		<input type='text' data-stripe='number'>
	</label>
<label id="cvc">
	<span>CVC:</span>
	<input type="text" data-stripe="cvc"> 
</label>
<label>
	<span>Expiry Date:</span>
	<br>
	{{ Form::selectMonth(null, null, ['data-stripe'=>'exp-month'])}}
	{{ Form::selectYear(null,date('Y'), date('Y')+10, null, ['data-stripe'=>'exp-year'])}}
</label>
{{ Form::hidden('email',$data['email'])}}
{{ Form::hidden('hash',$hash)}}
{{ Form::submit('Purchase', ['class'=>'button big'])}}

</label>

</div>

{{Form::close()}}