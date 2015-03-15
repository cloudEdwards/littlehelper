
<div class="textblock">
	
	<p>or Pay Pal.</p>
</div>

<!-- PayPal Buy Now Button -->

<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="7XZKPUYV6CEDE">

<input type="hidden" name="handling" value="15.14">
<input type="hidden" name="quantity" value="1">

<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>


{{Form::open(['route'=>'buy.checkout'])}}
{{Form::hidden('hash', $hash)}}
{{Form::submit('PayPal')}}

{{Form::close()}}

