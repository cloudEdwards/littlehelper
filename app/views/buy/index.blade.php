@extends('layouts.main')

@section('content')

	<h2>Ordering</h2>

	<img id="chainsaw" src="img/chainsaw.png" alt="a wooden toy chainsaw">

    {{ Form::open( array("route" => "buy.confirm") ) }}

    @include('buy.partials._form')

    {{ Form::close()}}
@stop