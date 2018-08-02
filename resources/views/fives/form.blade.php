
{!! Form::label('email_address', 'Email Address', ['class' => 'control-label']) !!}
{!! Form::email('email_address', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}

{!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
{!! Form::text('name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}

{!! Form::label('video', 'Video', ['class' => 'control-label']) !!}
{!! Form::file('video', null, ['class' => 'form-control', 'required' => 'required']) !!}

{!! Form::label('referral_emails', 'Referral Emails', ['class' => 'control-label']) !!}
{!! Form::email('referral_emails', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}

{!! Form::label('ethereum_address', 'Ethereum Address', ['class' => 'control-label']) !!}
{!! Form::text('ethereum_address', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}

<br>
{!! NoCaptcha::renderJs() !!}
{!! NoCaptcha::display() !!}

<p><input id="field_terms" type="checkbox" required>
<label for="field_terms">I accept the <u>Terms and Conditions</u></label></p>

{!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary form-margin']) !!}
