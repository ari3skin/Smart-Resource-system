@component('mail::message')
# Dear {{$first_name}} {{$last_name}}

Your application of the following project has been rejected due to some administrative reasons
<br>
@component('mail::panel')
**Project Title:** {{$project_title}}
<br>
**Project Description:** {{$project_description}}
@endcomponent
<br>

Regards,<br>
{{ config('app.name') }}
@endcomponent
