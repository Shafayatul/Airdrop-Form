
{!! Form::label('phone_number', 'Phone Number', ['class' => 'control-label']) !!}
{!! Form::text('phone_number', null, ['class' => 'form-control', 'required' => 'required']) !!}


<br>
{!! NoCaptcha::renderJs() !!}
{!! NoCaptcha::display() !!}

{!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary form-margin']) !!}
