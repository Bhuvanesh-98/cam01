@component('mail::message')
# Hello

Your Password verification code is {{$code}}



Thanks,<br>
{{ config('app.name') }}
@endcomponent
