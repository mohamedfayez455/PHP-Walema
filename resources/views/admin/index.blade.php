@include('admin.layouts.header')

@include('admin.layouts.navbar')


@include('admin.layouts.sidebar')

<div class="content-wrapper">
	<section class="content-header">
		@include('admin.layouts.messages')
	      <h1>
	        Dashboard
	        <small>Control panel</small>
	      </h1>
	      <ol class="breadcrumb">
	        <li><a href="#"><i class="fa fa-dashboard"></i> {{$title ?? 'Home'}}</a></li>
	        <li class="active">Dashboard</li>
	      </ol>
	</section>

	<section class="content">
		@yield('content')
	</section>

</div>

@include('admin.layouts.footer')