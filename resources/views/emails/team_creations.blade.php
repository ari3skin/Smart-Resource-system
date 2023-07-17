@component('mail::message')
# Greetings
You are receiving this email to notify you that you have been added to a team by: {{$employer->first_name}} {{$employer->last_name}}

The following team members have been assigned to the team:

@component('mail::panel')
@foreach ($names as $name)
- {{ $name }}
@endforeach
@endcomponent
<br>
Your assigned team is:
@component('mail::panel')
{{$teamInfo->team_name}}
@endcomponent
<div style="text-align: center;">Click here to open your dashboard and view your team</div>
@component('mail::button', ['url' => 'http://127.0.0.1:8000/admin'])
Open Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
