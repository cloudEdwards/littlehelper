
<ul class="errors">
    @foreach($errors->all('<small class="error">:message</small>') as $message)
        {{ $message }}
    @endforeach
</ul>

<div class="forms">

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

    <div id="msg">
        {{ Form:: label ('message', 'Message*' )}}
        {{ Form:: textarea ('message', '')}}
    </div>

    {{ Form::reset('Clear', array('class' => 'button big')) }}
    {{ Form::submit('Send', array('class' => 'button big')) }}

</div>
