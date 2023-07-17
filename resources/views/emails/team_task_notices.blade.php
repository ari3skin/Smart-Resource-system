@component('mail::message')
# Greetings
You are receiving this email to notify you that your team {{$teamInfo->team_name}}, created by:
@component('mail::panel')
**Team Leader:** {{$employer->first_name}} {{$employer->last_name}}
@endcomponent
Has been assigned a new task. The team's task details are as follows
@component('mail::panel')
**Task title:** {{$taskInfo->task_title}}
<br>
**Task description:** {{$taskInfo->task_description}}
@endcomponent
<br>

Regards,<br>
{{ config('app.name') }}
@endcomponent
