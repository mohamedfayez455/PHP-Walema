
@extends('admin.index')

@section('content')


@push('css')
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/dist/select2/css/select2.min.css"">
@endpush

@push('js')

	<script  src="{{url('/')}}/dist/select2/js/select2.min.js"></script>
	<script src="{{ url('/') }}/admin_design/js/form_builder_add_field.js"></script>
	<script src="{{ url('/') }}/admin_design/js/form_builder_edit_field.js"></script>
	<script src="{{ url('/') }}/admin_design/js/form_builder_delete_field.js"></script>

	<script type="text/javascript">
		$('.editBtn').on('click' , function() {

				var iteration = $('.i').val().split(',');


                   for(i = 0 ; i < iteration.length ; i++){

                   		$('#EditAttr-' + iteration[i]).empty();

                	}

				var input_id = this.attributes.id.value;

				var url = '{{ url(Request::segment(1). '/' .Request::segment(2))}}/get_input_attribute_with_value';

				makeAjaxEdit(url , input_id);

			}
		);
	</script>
@endpush

<?php $i = 0?>
@foreach($inputsWithAttribute as $key => $attributes)

	<div>
		<div class="form-group">

		  	<label for="attributes" style="text-transform: uppercase">{{ $key }}</label>

		  	@if( ! in_array( $key, ['type' , 'name' , 'message' , 'firstname' , 'lastname' , 'email' , 'password' , 'password_confirmation' , 'country_id'] ) )
		  	<button class="pull-right btn btn-primary editBtn" style="margin-right: 10px" id="{{$ids[$i]}}" data-toggle="modal" data-target="#edit-{{$ids[$i]}}">Edit</button>
		  	@include('admin.form_builder.tabs.edit')



		  	<button class="pull-right btn btn-danger" style="margin-right: 10px" data-toggle="modal" data-target="#delete-{{$ids[$i]}}">Delete</button>
		  	@include('admin.form_builder.tabs.delete')

		  	@endif

		</div>

		{!! Form::select('attributes' ,  $attributes , 0 , ['class' => 'form-control' , 'style' => 'margin:5px auto']) !!}


	</div>
	<?php $i++?>

@endforeach


<input type="hidden" class="i" value="{{ implode(',', $ids) }}">

@if( str_contains( URL::Current() , 'suppliers_profile_builder' ) )
<a href="{{ asset('/admin/' . Request::segment(2)) }}" class="btn btn-info">
	Add Fields
</a>

@elseif( str_contains( URL::Current() , 'customers_profile_builder' ) )
<a href="{{ asset('/admin/' . Request::segment(2)) }}" class="btn btn-info">
	Add Fields
</a>

@elseif( str_contains( URL::Current() , 'enquiry_form_builder' ) )
<a href="{{ asset('/admin/' . Request::segment(2)) }}" class="btn btn-info">
	Add Fields
</a>

@endif

@endsection

