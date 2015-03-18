
<?php  
	$data = $invoice['data'];
	$order = $invoice['order'];
	$price = $invoice['price'];
	$total = $invoice['total'];
 ?>

 <style type="text/css"> table,tr,th,td {border:solid;} </style>

<h2>Thank you for your business!</h2>

<p>We will send your order as soon as we confirm the transaction on our end.</p>

<h3><small>Invoice Code: {{$order['id']}}</small></h3>
<h3>Price: ${{number_format($price/100,2)}}</h3>
<h3>Quantity: {{$order['quantity']}}</h3>
<h3>Sub Total: ${{number_format($price/100 * $order['quantity'],2)}}</h3>
<h3>Shipping: ${{number_format($order['shipping'],2)}}</h3>
<h3><strong>Total: ${{number_format($total/100,2)}}</strong></h3>
<br>
<h3><small>Name: {{$order['name']}}</small></h3>
<h3><small>Phone: {{$order['phonenumber']}}</small></h3>
<h3><small>Email: {{$order['email']}}</small></h3>
<h3><small>Address: {{$order['address']}}</small></h3>
<h3><small>City: {{$order['city']}}</small></h3>
<h3><small>Prvince/State: {{$order['province']}}</small></h3>
<h3><small>Country: {{$order['country']}}</small></h3>
<h3><small>Postal/Zip Code: {{$order['postalcode']}}</small></h3>



