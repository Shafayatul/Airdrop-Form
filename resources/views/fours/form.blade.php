
{!! Form::label('email_address', 'Email Address', ['class' => 'control-label']) !!}
{!! Form::email('email_address', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}

{!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
{!! Form::text('name', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}

{!! Form::label('university_email_address', 'University Email Address', ['class' => 'control-label']) !!}
{!! Form::email('university_email_address', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}

{!! Form::label('university_website', 'University Website', ['class' => 'control-label']) !!}
{!! Form::text('university_website', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}

{!! Form::label('undergraduate_major', 'Undergraduate Major', ['class' => 'control-label']) !!}
{!! Form::text('undergraduate_major', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}

{!! Form::label('graduation_year', 'Graduation Year', ['class' => 'control-label']) !!}
{!! Form::text('graduation_year', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}

{!! Form::label('university_ambassadors', 'University Ambassadors', ['class' => 'control-label']) !!}
{!! Form::text('university_ambassadors', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}

{!! Form::label('ethereum_address', 'Ethereum Address', ['class' => 'control-label']) !!}
{!! Form::text('ethereum_address', null, ('' == 'required') ? ['class' => 'form-control', 'required' => 'required'] : ['class' => 'form-control']) !!}

{{-- {!! Form::label('terms_and_privacy_policy', 'Terms and Privacy Policy * Do you understand and agree to the Project Oblio OBL Airdrop Terms and Privacy Policy listed here? http://projectoblio.com/2018/07/02/airdrop-terms-and-privacy-policy/', ['class' => 'control-label']) !!} --}}

{{-- {!! Form::radio('', "Yes, I understand and agree to the Terms and Privacy Policy", true) !!} --}}
{{-- {!! Form::radio('terms_and_privacy_policy', "No, I do not agree to the Terms and Privacy Policy", false) !!} --}}


{!! Form::submit(isset($submitButtonText) ? $submitButtonText : 'Create', ['class' => 'btn btn-primary form-margin']) !!}
