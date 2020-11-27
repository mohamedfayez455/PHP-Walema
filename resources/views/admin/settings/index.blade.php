@extends('admin.index')

@push('js')


<script>
	
	if ( $('.status').val() == 'close' ){
		
		$('.message_maintenance').removeClass('hidden');

	}

	$('.status').on('change', function() {

		if ( $(this).val() == 'close' ){
		
			$('.message_maintenance').removeClass('hidden');

		}else{
			$('.message_maintenance').addClass('hidden');
		}		

	});



</script>

@endpush

@section('content')


            <div class="box-header">
              <h3 class="box-title">{{ $title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              {!! Form::open(['route' => ['settings.update']  , 'method' => 'PUT', 'files' => true]) !!}
              
              <div class="form-group">
                {!! Form::label('app_name' ,  'App Name' ) !!}
                {!! Form::text('app_name' , $setting->app_name , ['class' => 'form-control'] ) !!}  
              </div>

              @if($setting->icon)
                <img src="{{ Storage::url($setting->icon) }}" width="50px" height="50px">
              @endif

              <div class="form-group">
                {!! Form::label('icon' ,  'Icon' ) !!}
                {!! Form::file('icon' , ['class' => 'form-control'] ) !!}  
              </div>

              <div class="form-group">
                {!! Form::label('email' ,  'Email' ) !!}
                {!! Form::email('email' , $setting->email , ['class' => 'form-control'] ) !!}  
              </div>

              <div class="form-group">
                {!! Form::label('description' ,  'Description' ) !!}
                {!! Form::textarea('description' , $setting->description , ['class' => 'form-control'] ) !!}  
              </div>

              <div class="form-group">
                {!! Form::label('status' ,  'Status' ) !!}
                {!! Form::select('status' ,  [ 'open' => 'Open' , 'close' => 'Close' ] , $setting->status , ['class' => 'form-control status'] ) !!}  
              </div>

			  <div class="form-group message_maintenance hidden">
                {!! Form::label('message_maintenance' ,  'Message Maintenance' ) !!}
                {!! Form::textarea('message_maintenance' , $setting->message_maintenance , ['class' => 'form-control'] ) !!}  
              </div>

              {!! Form::submit( 'Save' , ['class' => 'btn btn-primary'] ) !!}
              {!! Form::close() !!}
            </div>
   
@endsection