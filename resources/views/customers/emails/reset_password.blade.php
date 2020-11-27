@component('mail::message')

Reset password {{ $data['customer']->name }}'s acccount

@component('mail::button', ['url' => url('customers/reset/password/' . $data['token']) ])
Click To Reset Your Password
@endcomponent

OR<br>
Copy This Link

<a href="{{ url('customers/reset/password/' . $data['token']) }}"> {{ aurl('reset-password/' . $data['token']) }} </a>

Thanks,<br>
{{ app_name() }}
@endcomponent
