@component('mail::message')

You received a {{ $data['type'] }} from : {{ $data['email'] }} : ( {{ $data['name'] }} )



<p>{{ $data['message'] }}</p>

Thanks,<br>
{{ app_name() }}
@endcomponent
