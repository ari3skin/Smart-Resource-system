@component('mail::message')
# Dear {{$first_name}} {{$last_name}}

Your application of the following project has been approved
<br>
@component('mail::panel')
**Project Title:** {{$project_title}}
<br>
**Project Description:** {{$project_description}}
@endcomponent
<br><br>
<div style="text-align: center;">Click here to open your dashboard and view your project</div>
@component('mail::button', ['url' => 'http://127.0.0.1:8000/admin'])
Open Dashboard
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
