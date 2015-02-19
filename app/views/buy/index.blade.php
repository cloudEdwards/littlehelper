@extends('layouts.main')

@section('content')

	<h2>Buy Now</h2>

	{{ Form:: label ('quantity', 'Quantity' )}}
    {{ Form:: number ('number')}}

    {{ Form:: label ('shipping-address', "Shipping Address") }}
    {{ Form:: text ('address')}}

	{{ Form:: label ('apt', "Apartment Number") }}
    {{ Form:: text ('apt')}}

    {{ Form:: label ('province', "Province/State") }}
    {{ Form:: text ('province')}}

    {{ Form:: label ('postal-code', "Postal/Zip Code") }}
    {{ Form:: text ('postalcode')}}

    {{ Form:: label ('provicne', "Province/State") }}
    {{ Form:: text ('province')}}

    {{ Form:: submit ('Calculate Shipping' , array('class'=>'calculate button'))}}

    



@stop