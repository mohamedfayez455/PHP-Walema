@if($errors->any())
	<div class="text-center alert alert-danger">
		<ul>
			@foreach($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif

@if( session('success') )
	<div class="text-center alert alert-success">
		<h3>{{ session('success') }}</h3>
	</div>
@endif

@if( session('error') )
	<div class="text-center alert alert-danger">
		<h3>{{ session('error') }}</h3>
	</div>
@endif

@if( session('info') )
	<div class="text-center alert alert-info">
		<h3>{{ session('info') }}</h3>
	</div>
@endif

@if( session('warning') )
	<div class="text-center alert alert-warning">
		<h3>{{ session('warning') }}</h3>
	</div>
@endif