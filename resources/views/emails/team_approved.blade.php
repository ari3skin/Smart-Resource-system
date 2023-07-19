@component('mail::message')
# Greetings
You are receiving this email to notify you that your team named: {{$teamInfo->team_name}}, created by:
@component('mail::panel')
**Team Leader:** {{$employer->first_name}} {{$employer->last_name}}
@endcomponent
whose members are:
@component('mail::panel')
@foreach ($names as $name)
- {{ $name }}
@endforeach
@endcomponent
has successfully passed the organization's review check and been activated.
<br>

Regards,<br>
{{ config('app.name') }}
@endcomponent
