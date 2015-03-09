
<p id="left">
	*Please review your information, then enter your credit card information to complete your purchase.<br><br>
	Quantity: {{ $data['quantity']}}<br>
	{{--!!!!! Get Real Price From DataBase !!!!!! --}}
	Price: $100.00 cad<br>  
	Total: {{100 * $data['quantity']}}.00 cad<br><br>
	{{--!!!!! Get Real Price From DataBase !!!!!! --}}
	Name: {{ $data['first-name'].' '.
		$data['middle-name'].' '.
		$data['last-name']}}<br>
	Phone Number: {{ $data['phone-number']}}<br>
	Email: {{ $data['email']}}<br>
	Shipping Address: {{ $data['address']}}<br>
	Province/State: {{ $data['province']}}<br>
	Country: {{ $data['country']}}<br>
	Postal/Zip Code: {{ $data['postal-code']}}<br>
</p>	

{{ Form::open(['id'=>'billing-form']) }}

<div class="payment-errors error"></div>

<div class="forms credit">
	<label>
		<span>Card Number:</span>
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
	{{ Form::selectYear(null,date('y'), date('y')+10, null, ['data-stripe'=>'exp-month'])}}
</label>
{{ Form::submit('Confirm Purchase', ['class'=>'next button'])}}

</label>

</div>

{{Form::close()}}