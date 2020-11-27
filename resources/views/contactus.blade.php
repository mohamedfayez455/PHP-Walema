@component('mail::message')

{{ $data['email'] }} : ( {{ $data['name'] }} ) : Contact With Us

Subject: {{ $data['subject']}}


<p>{{ $data['content'] }}</p>

Thanks,<br>
{{ app_name() }}
@endcomponent
