@component('mail::message')

{{ admin()->firstname . ' ' . admin()->lastname }} Send Quick Email


{{ $data['subject'] }} :

<br>

{{ $data['message'] }}


Thanks,<br>
{{ app_name() }}
@endcomponent
