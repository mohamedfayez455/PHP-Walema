@component('mail::message')

Reset password {{ $data['admin']->username }}'s acccount

@component('mail::button', ['url' => aurl('reset-password/' . $data['token']) ])
Click To Reset Your Password
@endcomponent

OR<br>
Copy This Link

<a href="{{ aurl('reset-password/' . $data['token']) }}"> {{ aurl('reset-password/' . $data['token']) }} </a>

Thanks,<br>
{{ app_name() }}
@endcomponent
