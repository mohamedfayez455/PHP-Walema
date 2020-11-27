
@extends('admin.index')

@section('content')


@push('css')
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/dist/select2/css/select2.min.css"">
@endpush

@push('js')

	<script  src="{{url('/')}}/dist/select2/js/select2.min.js"></script>

	<style type="text/css">

		.FormBuilder
		{
			border:thin black solid;
		  	margin:10px;
		  	padding:20px;
		}

	</style>

	<script src="{{url('/')}}/admin_design/js/show_form_builder.js"></script>
	<script src="{{url('/')}}/admin_design/js/form_builder_add_field.js"></script>

	<script>

		var url = '{{ URL::Current() }}/get_profile_builder';

		showFormBuilder(url , '.FormBuilder' , null);

	</script>


@endpush



<form class="FormBuilder container">

	{{csrf_field()}}

</form>

<br>


<button class="btn btn-info" data-toggle="modal" data-target="#modal-field">
	Add New Field
</button>


	<a href="{{ route( Request::segment(2) . '.edit_form_builder') }}" class="btn btn-info pull-right">
		Edit Form Builder
	</a>

@include('admin.form_builder.tabs.add')

@endsection


