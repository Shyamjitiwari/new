{{ __('sms_and_email.email_title') }}, <br/><br/>
{{ __('sms_and_email.reference_email_message', ['PhoneNumber' => $data['referred_by_phone']]) }}.<br><br>

Camps: {{ __('sms_and_email.reference_link_to_camps', ['HashedReference' => $data['hashed_reference']]) }}<br/>
Free Session: {{ __('sms_and_email.reference_link_to_free_session', ['HashedReference' => $data['hashed_reference']]) }}<br/>
<br/>

{{ __('sms_and_email.step_by_step_instructions_to_setup_portal_in_reference_email', ['PhoneNumber' => $data['referred_by_phone']]) }}
<br/><br/>
{{ __('sms_and_email.faqs_link') }}

<br/><br/><br/>
{{ __('sms_and_email.if_you_have_questions') }}<br/>
{{ __('sms_and_email.respond_to_email') }}<br/>
{{ __('sms_and_email.text_or_call_at') }}<br/><br/>

Code With Us Team