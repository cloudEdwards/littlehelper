<div class="forms">

    <ul class="errors">
        @foreach($errors->all('<small class="error">:message</small>') as $message)
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

</div>
