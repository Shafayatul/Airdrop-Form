
{!! Form::label('ethereum_address', 'Ethereum Address', ['class' => 'control-label']) !!}
{!! Form::text('ethereum_address', null, ['class' => 'form-control', 'required' => 'required']) !!}

{!! Form::label('ip', 'IP', ['class' => 'control-label']) !!}
{!! Form::text('ip', null, ['class' => 'form-control', 'required' => 'required']) !!}

<br>
{!! NoCaptcha::renderJs() !!}
{!! NoCaptcha::display() !!}

{!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary form-margin']) !!}
