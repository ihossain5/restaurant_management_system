@component('mail::message')
# {{ $maildata['title'] }} 

{{ $maildata['message'] }} 

Sign up and use Emerald now

@component('mail::button', ['url' => $maildata['url']])
Sign up
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
