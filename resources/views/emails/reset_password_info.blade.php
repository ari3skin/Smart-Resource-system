<x-mail::message>
# Dear {{$first_name}} {{$last_name}},
<br>
You are receiving this email because you have requested for a password reset.
<br>
Kindly click on the link below to reset your password
<br>

@component('mail::button', ['url' => 'http://127.0.0.1:8000/auth/form_reset/' . $token])
Reset Password
@endcomponent

Best regards,<br>
{{ config('app.name') }}
</x-mail::message>
