@if( $avatar )
	<img src="{{ Storage::url($avatar) }}" width="50px" height="50px">
@else
	<img src="{{ asset('/img/default_user.png') }}" width="50px" height="50px">
@endif