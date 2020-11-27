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
    "data":{!! load_categories() !!},
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

    id   = data.instance.get_node(data.selected[i]).id ;

    name = data.instance.get_node(data.selected[i]).text;
  }

  if (id) {

    $('.parent_id').val(id);

  }

});

</script>




@endpush

@section('content')


              {!! Form::open(['route' => 'supplier-categories.store' , 'files' => true]) !!}
              <div class="form-group">
                {!! Form::label('name' ,  'Name' ) !!}
                {!! Form::text('name' , old('name') , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                  <div class="jstree"></div>
              </div>

              <div class="form-group">
                {!! Form::hidden('parent_id' , old('parent_id') , ['class' => 'parent_id form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('photo' ,  'photo' ) !!}
                {!! Form::file('photo' , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('desc' ,  'Description' ) !!}
                {!! Form::textarea('desc' , old('desc') , ['class' => 'form-control'] ) !!}
              </div>

              {!! Form::submit( 'Create Supplier Category' , ['class' => 'btn btn-primary'] ) !!}
              {!! Form::close() !!}

@endsection