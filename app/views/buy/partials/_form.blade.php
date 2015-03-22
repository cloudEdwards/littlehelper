

<div class="forms">

    <p>* Required</p>

     {{$errors->first('quantity', '<small class="error">:message</small>')}}
    {{ Form:: label ('quantity', 'Quantity*' )}}
    {{ Form::selectRange('quantity', 1, 100);}}

    {{$errors->first('first-name', '<small class="error">:message</small>')}}
    {{ Form:: label ('first-name', "First Name*") }}
    {{ Form:: text ('first-name')}}
   
    {{ Form:: label ('middle-name', "Middle Name") }}
    {{ Form:: text ('middle-name')}}

    {{$errors->first('last-name', '<small class="error">:message</small>')}}
    {{ Form:: label ('last-name', "Last Name*") }}
    {{ Form:: text ('last-name')}}

    {{$errors->first('phone-number', '<small class="error">:message</small>')}}
    {{ Form:: label ('phone-number', "Phone Number*") }}
    {{ Form:: text ('phone-number')}}

    {{$errors->first('email', '<small class="error">:message</small>')}}
    {{ Form:: label ('email', "Email*") }}
    {{ Form:: email ('email')}}

    {{$errors->first('address', '<small class="error">:message</small>')}}
    {{ Form:: label ('address', "Shipping Address*") }}
    {{ Form:: text ('address')}} 

    {{ Form:: label ('apt', "Apt.", ['class'=>'small form']) }}
    {{ Form:: text ('apt')}}
    {{ Form:: label ('pobox', "PO Box", ['class'=>'small form']) }}
    {{ Form:: text ('pobox')}}
    {{ Form:: label ('rr', "RR", ['class'=>'small form']) }}
    {{ Form:: text ('rr')}}

    {{$errors->first('city', '<small class="error">:message</small>')}}
    {{ Form:: label ('city', "City*") }}
    {{ Form:: text('city')}}

    {{$errors->first('province', '<small class="error">:message</small>')}}
    {{ Form:: label ('province', "Province/State*") }}
    {{ Form:: text('province')}}

    {{$errors->first('country', '<small class="error">:message</small>')}}
    {{ Form:: label ('country', "Country*") }}
    {{ Form:: text ('country')}}

    {{$errors->first('postal-code', '<small class="error">:message</small>')}}
    {{ Form:: label ('postal-code', "Postal/Zip Code*") }}
    {{ Form:: text ('postal-code')}}

    {{ Form:: submit ('Next' , array('class'=>'button big'))}}

</div>

