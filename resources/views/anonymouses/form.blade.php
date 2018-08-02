
{!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
{!! Form::text('email', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}

{!! Form::label('ethereum_address', 'Ethereum Address', ['class' => 'control-label']) !!}
{!! Form::text('ethereum_address', null, ('required' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}

{!! Form::label('number', 'Number', ['class' => 'control-label']) !!}
{!! Form::select('number', ['2'=> '2','3'=> '3','4'=> '4','5'=> '5','6'=> '6','7'=> '7','8'=> '8','9'=> '9','10'=> '10','11'=> '11','12'=> '12','13'=> '13','14'=> '14','15'=> '15','16'=> '16','17'=> '17','18'=> '18','19'=> '19','20'=> '20'], null, ['class' => 'form-control', 'required' => 'required']) !!}

<br>
{!! NoCaptcha::renderJs() !!}
{!! NoCaptcha::display() !!}
<br>
<p><input id="field_terms" type="checkbox" required>
<label for="field_terms">I accept the <u>Terms and Conditions</u></label></p>

{!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary form-margin']) !!}
