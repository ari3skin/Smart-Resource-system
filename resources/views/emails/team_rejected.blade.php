@component('mail::message')
# Greetings
You are receiving this email to notify you that your team {{$teamInfo->team_name}}, created by:
@component('mail::panel')
**Team Leader:** {{$employer->first_name}} {{$employer->last_name}}
@endcomponent
whose members are:
@component('mail::panel')
@foreach ($names as $name)
- {{ $name }}
@endforeach
@endcomponent
has been rejected due to some administrative reasons
<br>

<div style="text-align: center;">Click here to open your dashboard and view your team</div>
@component('mail::button', ['url' => 'http://127.0.0.1:8000/admin'])
Open Dashboard
@endcomponent

Regards,<br>
{{ config('app.name') }}
@endcomponent
