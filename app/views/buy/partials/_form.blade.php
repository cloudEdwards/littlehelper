

<div class="forms">

     {{$errors->first('quantity', '<small class="error">:message</small>')}}<br>
    {{ Form:: label ('quantity', 'Quantity' )}}
    {{ Form::selectRange('quantity', 1, 100);}}

    {{$errors->first('first-name', '<small class="error">:message</small>')}}<br>
    {{ Form:: label ('first-name', "First Name") }}
    {{ Form:: text ('first-name')}}
   
    {{ Form:: label ('middle-name', "Middle Name") }}
    {{ Form:: text ('middle-name')}}

    {{$errors->first('last-name', '<small class="error">:message</small>')}}<br>
    {{ Form:: label ('last-name', "Last Name") }}
    {{ Form:: text ('last-name')}}

    {{$errors->first('phone-number', '<small class="error">:message</small>')}}<br>
    {{ Form:: label ('phone-number', "Phone Number") }}
    {{ Form:: text ('phone-number')}}

    {{$errors->first('email', '<small class="error">:message</small>')}}<br>
    {{ Form:: label ('email', "Email") }}
    {{ Form:: text ('email')}}

    {{$errors->first('address', '<small class="error">:message</small>')}}<br>
    {{ Form:: label ('address', "Shipping Address") }}
    {{ Form:: text ('address')}} 

    {{$errors->first('province', '<small class="error">:message</small>')}}<br>
    {{ Form:: label ('province', "Province/State") }}
    {{ Form:: text('province')}}

    {{$errors->first('country', '<small class="error">:message</small>')}}<br>
    {{ Form:: label ('country', "Country") }}
    {{ Form:: text ('country')}}

    {{$errors->first('postal-code', '<small class="error">:message</small>')}}<br>
    {{ Form:: label ('postal-code', "Postal/Zip Code") }}
    {{ Form:: text ('postal-code')}}

    {{ Form:: submit ('Next' , array('class'=>'next button big'))}}

</div>

