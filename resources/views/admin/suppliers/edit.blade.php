@extends('admin.index')


@push('css')
<link rel="stylesheet" type="text/css" href="{{url('/')}}/admin_design/jstree/dist/themes/default/style.css">
@endpush

@push('js')

<script src="{{url('/')}}/admin_design/jstree/src/jstree.js"></script>
<script src="{{url('/')}}/admin_design/jstree/dist/jstree.min.js"></script>
<script src="{{url('/')}}/admin_design/jstree/src/jstree.checkbox.js"></script>
<script src="{{url('/')}}/admin_design/jstree/src/jstree.wholerow.js"></script>



<script>

$('.jstree').jstree({

  "core":{
    "data":{!! load_categories( $user->supplier->categories_id ) !!},
    "themes":{
          "variant" : "large"
        }
  },
  "checkbox":{
    "keep_selected_style" : true
  },
  "plugins":["wholerow"]
});

$('.jstree').on('changed.jstree' , function(e,data){

  var i , j , ids = [] , names = [];

  for (var i = 0 , j = data.selected.length ; i < j ; i++) {

    ids[i]   = data.instance.get_node(data.selected[i]).id ;

  }

  if (ids) {

    $('.categories_id').val( ids );

  }

});

</script>


@endpush

@section('content')


              {!! Form::open(['route' => ['suppliers.update' , $user->supplier->id] , 'method' => 'PUT' , 'files' => true]) !!}
              <div class="form-group">
                {!! Form::label('firstname' ,  'First Name' ) !!}
                {!! Form::text('firstname' , $user->firstname , ['class' => 'form-control' , 'placeholder'=> 'First Name'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('lastname' ,  'Last Name' ) !!}
                {!! Form::text('lastname' , $user->lastname , ['class' => 'form-control' , 'placeholder'=> 'Last Name'] ) !!}
              </div>
              <div class="form-group">
                {!! Form::label('email' ,  'Email' ) !!}
                {!! Form::text('email' , $user->email , ['class' => 'form-control' , 'placeholder'=> 'Email'] ) !!}
              </div>

              @if($user->avatar)
              <img src="{{ Storage::url($user->avatar)}}" width="100px" height="100px">
              @else
              <img src="{{ asset('/img/default_supplier.jpg') }}" width="100px" height="100px">
              @endif
              <div class="form-group">
                {!! Form::label('avatar' ,  'avatar' ) !!}
                {!! Form::file('avatar' , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('Country' ,  'Country' ) !!}
                {!! Form::select('country_id' , App\Country::pluck('name' , 'id') , $user->country_id , ['class' => 'form-control' , 'placeholder'=> 'Password'] ) !!}
              </div>


              {!! Form::submit( 'Edit Supplier' , ['class' => 'btn btn-primary'] ) !!}
              {!! Form::close() !!}

@endsection