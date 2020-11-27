@include('layouts.header')

 @if( is_authenticated() and is_supplier() and str_contains( request()->path()  ,'dashboard' ) )
	@include('includes.suppliernav')
 @elseif( is_authenticated() and is_customer() and str_contains( request()->path()  ,'dashboard' ) )
	@include('includes.customernav')
 @endif

	<section class="clearfix pageTitleSection bg-image" style="background-image: url(img/banner/mo.jpg);">
	  <div class="container">
	    <div class="row">
	      <div class="col-xs-12">
	        <div class="pageTitle">
				<h2> @yield('name') </h2>
			</div>
	      </div>
	    </div>
	  </div>
	</section>


  @yield('title')

  @yield('paragraph')
  @yield('content')

@include('layouts.footer')

