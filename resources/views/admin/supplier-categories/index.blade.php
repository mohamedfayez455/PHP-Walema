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

		id 	 = data.instance.get_node(data.selected[i]).id ;

		name = data.instance.get_node(data.selected[i]).text;
	}

	if (id) {

		$('.edit').removeClass('hidden');
		$('.edit').attr('href', "{{ aurl('supplier-categories')}}/" + id + "/edit");
		
		$('.delete').removeClass('hidden');

		$('.dep_name').html(name);


		$('.form_delete_category').attr('action' ,'{{ aurl('/supplier-categories')}}/' + id) ;

	}else{
		
		$('.edit').addClass('hidden');
		$('.delete').addClass('hidden');

	}

});

</script>




@endpush




@section('content')
		
		<div id="delete_category" class="modal fade" role="dialog">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Delete Category</h4>
		      </div>
		      {!! Form::open(['url'=>'' ,'method'=>'DELETE' , 'class' => 'form_delete_category']) !!}
		      <div class="modal-body">

		        <h4>Do You Want To Remove It ? </h4>
		        <h4 class="dep_name text-danger"></h4>

		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
		        {!! Form::submit("Yes",['class'=>'btn btn-danger']) !!}
		      </div>
		      {!! Form::close() !!}
		    </div>

		  </div>
		</div>

		<div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ $title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            	<a href="" class="btn btn-info edit hidden"><i class="fa fa-edit"></i> Edit</a>
            	<a href="" class="btn btn-danger delete hidden" data-toggle="modal" data-target="#delete_category">
            		<i class="fa fa-trash"></i> Delete
            	</a>

            	<div class="jstree"></div>

            </div>
	            <!-- /.box-body -->
		</div>


@endsection