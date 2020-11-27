@include('layouts.header')

 @if( is_authenticated() and is_supplier() and str_contains( request()->path()  ,'dashboard' ) )
	@include('includes.suppliernav')
 @elseif( is_authenticated() and is_customer() and str_contains( request()->path()  ,'dashboard' ) )
	@include('includes.customernav')
 @endif


  @yield('content')


@include('layouts.footer')