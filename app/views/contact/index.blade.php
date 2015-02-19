@extends('layouts.main')

@section('content')

	<h2>Contact</h2>


<!-- Blade Template engine -->
 {{ Form:: open(array('url' => 'contact_request')) }} <!--contact_request is a router from Route class-->
 
            <ul class="errors">
                @foreach($errors->all('<li>:message</li>') as $message)
                {{ $message }}
                @endforeach
            </ul>
 
            {{ Form:: label ('first_name', 'First Name*' )}}
            {{ Form:: text ('first_name', '' )}}
 
            {{ Form:: label ('last_name', 'Last Name*' )}}
            {{ Form:: text ('last_name', '' )}}
 
            {{ Form:: label ('phone_number', 'Phone Number' )}}
            {{ Form:: text ('phone_number', '') }}
 
            {{ Form:: label ('email', 'E-mail Address*') }}
            {{ Form:: email ('email', '') }}
 
            {{ Form:: label ('subject', 'Subject') }}
            {{ Form:: text ('subject','' ) }}
 
            {{ Form:: label ('message', 'Message*' )}}
            {{ Form:: textarea ('message', '')}}
 
            {{ Form::reset('Clear', array('class' => 'form button')) }}
            {{ Form::submit('Send', array('class' => 'form button')) }}
 
            {{ Form:: close() }}

@stop