<x-mail::message>
# Dear {{$first_name}} {{$last_name}},
<br>
We are pleased to inform you that your account registration request has been accepted. You can now log in to our system
using the following credentials:
<br>
@component('mail::panel')
**Username:** {{$username}}
<br>
**Temporary Password:** {{$password}}
@endcomponent
<br>
Please note that for security purposes, we recommend you promptly reset your password upon logging in.

@component('mail::button', ['url' => 'http://127.0.0.1:8000/auth/create_reset/' . $user_id . ''])
Reset Password
@endcomponent

Once logged in, you will have the option to link your email to your Google account. This will enable faster login and
provide additional convenience in accessing our system. If you do not have a Google email, you can create one easily
by visiting the sign-up page below

@component('mail::button', ['url' => 'https://accounts.google.com/signup/v2/createaccount?flowName=GlifWebSignIn&flowEntry=SignUp'])
Google Sign Up
@endcomponent

Thank you for joining our system!
<br>

Best regards,<br>
{{ config('app.name') }}
</x-mail::message>
