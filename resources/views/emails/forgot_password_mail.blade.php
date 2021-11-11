@component('mail::message')
# {{ $maildata['title'] }} 

{{ $maildata['message'] }} 

@component('mail::button', ['url' => $maildata['url']])
Reset Password
@endcomponent

If you did not request a password reset, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
