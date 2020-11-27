@extends('admin.index')

@push('js')
	
	{!! $dataTable->scripts() !!}

	<script>
		Multidelete();
	</script>

@endpush

@section('content')
	
		<div class="box">
            <div class="box-header">
              <h3 class="box-title">{{ $title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

            	{!! Form::open(['id' =>'dataForm','url'=>aurl('supplier-types/destroy/all') , 'method' => 'DELETE' ]) !!}

                {!! $dataTable->table(['table' => 'dataTable table table-borderd table-striped table-hovered'] , true) !!}
                {!! Form::close() !!}
            </div>
	            <!-- /.box-body -->
		</div>

		<div id="multipleDelete" class="modal fade" role="dialog">
		  <div class="modal-dialog">

		    <!-- Modal content-->
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal">&times;</button>
		        <h4 class="modal-title">Delete Supplier</h4>
		      </div>
		      <div class="modal-body">
		        
		        <div class="alert alert-danger">

		          <div class="empty_record">
		              <h4>Please Check Record To Delete</h4>  
		          </div>

		          <div class="not_empty_record">
		              <h4>Do You Want To Delte This Records , <span class="record_count"></span> ? </h4>
		          </div>
		    
		        </div>

		      </div>
		      <div class="modal-footer">
		        <div class="empty_record">
		               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		        </div>

		        <div class="not_empty_record">
		             <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
		            <button type="button" class="btn btn-danger del_all" name="del_all">Yes</button>
		          </div>

		        
		      </div>
		    </div>

		  </div>
		</div>


@endsection