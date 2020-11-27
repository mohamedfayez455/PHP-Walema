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
    "data":{!! load_categories($category->parent_id , $category->id) !!},
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

  var i , j , id , name;

  for (var i = 0 , j = data.selected.length ; i < j ; i++) {

    id = data.instance.get_node(data.selected[i]).id ;
  }

  $('.parent_id').val(id);


});

</script>

@endpush



@section('content')


            <div class="box-header">
              <h3 class="box-title">{{ $title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              {!! Form::open(['route' => ['supplier-categories.update' , $category->id]  , 'method' => 'PUT', 'files' => true]) !!}
              <div class="form-group">
                {!! Form::label('name' ,  'Name' ) !!}
                {!! Form::text('name' , $category->name , ['class' => 'form-control'] ) !!}
              </div>

              <div class="jstree"></div>

              <div class="form-group">
                {!! Form::hidden('parent_id' , $category->parent_id , ['class' => 'parent_id form-control'] ) !!}
              </div>


              @if($category->photo)
                <img src="{{ $category->photo_path }}" width="50px" height="50px">
              @endif

              <div class="form-group">
                {!! Form::label('photo' ,  'Photo' ) !!}
                {!! Form::file('photo' , ['class' => 'form-control'] ) !!}
              </div>


              <div class="form-group">
                {!! Form::label('desc' ,  'Description' ) !!}
                {!! Form::text('desc' , $category->desc , ['class' => 'form-control'] ) !!}
              </div>

              {!! Form::submit( 'Save' , ['class' => 'btn btn-primary'] ) !!}
              {!! Form::close() !!}
            </div>

@endsection