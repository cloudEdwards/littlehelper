@extends('layouts.main')

@section('content')

	<h2>Buy Now</h2>

    {{ Form::open( array("route" => "buy.confirm") ) }}

    @include('buy.partials._form')

    {{ Form::close()}}
@stop