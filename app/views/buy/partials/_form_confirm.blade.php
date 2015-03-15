@if(isset($data))

<div class="textblock" id="left">
	<p>
		
		<table>
			<tr><th>Quantity: </th> <td>{{ $data['quantity']}}</td></tr>
		{{--!!!!! Get Real Price From DataBase !!!!!! --}}
			<?php 
				$quantity = $data['quantity'];
				$price = Prices::findOrFail(1);
				$price = $price['attributes']['price'];
				$price = number_format($price,2);
				$shippingRate = floatval($shipping_rates[0][1]);
				$subTotal = $price * $quantity + $shippingRate;
				$total = number_format($subTotal,2);
				$totalCents = $total *100;
			?>

			<tr><th>Price: </th> <td>${{{$price}}} Cad.</td></tr> 
			<tr><th>Shipping Rate: </th> <td>${{{$shippingRate}}} Cad.</td></tr>
			<tr><th>Total: </th> <td>${{{$total}}} Cad.</td></tr>

			<tr><th>Name: </th> <td>{{{ $data['first-name'].' '.$data['middle-name'].' '.$data['last-name'] }}}</td></tr>
			<tr><th>Phone Number: </th> <td>{{{ $data['phone-number']}}}</td></tr>
			<tr><th>Email: </th> <td>{{{ $data['email']}}}</td></tr>
			<tr><th>Shipping Address: </th> <td>{{{ $data['address']}}}</td></tr>

			@if(!empty($data['apt']) )
				<tr><th>Apt: </th><td>{{{ $data['apt']}}}</td></tr>
			@elseif(!empty($data['pobox']))
				<tr><th>PO Box: </th><td>{{{ $data['pobox']}}}</td></tr>
			@elseif(!empty($data['rr']))
				<tr><th>RR: </th><td>{{{ $data['rr']}}}</td></tr>
			@endif

			<tr><th>Province/State: </th> <td>{{ $data['province']}}</td></tr>
			<tr><th>Country: </th> <td>{{{ $data['country']}}}</td></tr>
			<tr><th>Postal/Zip Code: </th> <td>{{{ $data['postal-code']}}}</td></tr>
		</table>	
	</p>
	<a  href="javascript:history.go(-1)"><div class="button big">Edit</div></a>
		
		
</div>

@endif