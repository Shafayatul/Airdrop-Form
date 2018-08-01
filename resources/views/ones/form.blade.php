
{!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
{!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
{!! Form::label('address', 'Address', ['class' => 'control-label']) !!}
{!! Form::text('address', null, ['class' => 'form-control', 'required' => 'required']) !!}

{!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary form-margin']) !!}
