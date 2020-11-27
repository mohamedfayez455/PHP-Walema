@component('mail::message')

Reset password {{ $data['user']->name }}'s acccount

@component('mail::button', ['url' => url('/reset/password/' . $data['token']) ])
Click To Reset Your Password
@endcomponent

OR<br>
Copy This Link

<a href="{{ url('/reset/password/' . $data['token']) }}"> {{ url('reset-password/' . $data['token']) }} </a>

Thanks,<br>
{{ app_name() }}
@endcomponent
