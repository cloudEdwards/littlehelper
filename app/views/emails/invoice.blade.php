
<?php  
	$order = $invoice;
	$total = $invoice['amount'];
 ?>
 <style type="text/css"> table,tr,th,td {border:groove;} </style>

<h2>Thank you for your business!</h2>

<p>I will send your order as soon possible. I hope enjoy your chainsaw for generations, like I have.</p>
<p>~ Angel</p>


<h3>Quantity: {{$order['quantity']}}</h3>

<h3>Shipping: ${{number_format($order['shipping'],2)}}</h3>
<h3>Tax: ${{number_format($order['tax'],2)}}</h3>

<h3><strong>Total: ${{number_format($total,2)}}</strong></h3>
<br>
<h3><small>Name: {{$order['name']}}</small></h3>
<h3><small>Phone: {{$order['phonenumber']}}</small></h3>
<h3><small>Email: {{$order['email']}}</small></h3>
<h3><small>Address: {{$order['address']}}</small></h3>
<h3><small>City: {{$order['city']}}</small></h3>
<h3><small>Prvince/State: {{$order['province']}}</small></h3>
<h3><small>Country: {{$order['country']}}</small></h3>
<h3><small>Postal/Zip Code: {{$order['postalcode']}}</small></h3>


<h3><small>Invoice Code: {{$order['id']}}</small></h3>
