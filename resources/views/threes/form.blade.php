
{!! Form::label('phone_number', 'Phone Number', ['class' => 'control-label']) !!}
{!! Form::text('phone_number', null, ['class' => 'form-control', 'required' => 'required']) !!}

{{-- {!! Form::label('code', 'Code', ['class' => 'control-label']) !!}
{!! Form::text('code', null, ['class' => 'form-control', 'required' => 'required']) !!} --}}

{!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary form-margin']) !!}
