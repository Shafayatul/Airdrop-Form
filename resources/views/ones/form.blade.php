
{!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
{!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
{!! Form::label('address', 'Address', ['class' => 'control-label']) !!}
{!! Form::text('address', null, ['class' => 'form-control', 'required' => 'required']) !!}

<br>
{!! NoCaptcha::renderJs() !!}
{!! NoCaptcha::display() !!}

<p><input id="field_terms" type="checkbox" required>
<label for="field_terms">I accept the <u>Terms and Conditions</u></label></p>

{!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary form-margin']) !!}
