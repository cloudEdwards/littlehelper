@extends('layouts.main')

@section('content')

	<h2>Contact</h2>


<!-- Blade Template engine -->
 {{ Form:: open(array('url' => 'contact_request')) }} <!--contact_request is a router from Route class-->
 
            @include('contact.partials._form')
 
            {{ Form:: close() }}

@stop