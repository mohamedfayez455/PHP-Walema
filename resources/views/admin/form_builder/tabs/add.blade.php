<div class="modal modal-info fade" id="modal-field">
        <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Adding Field</h4>
              </div>
              <div class="modal-body">

		          <div class="row">
		            <div class="col-md-12">
		              <div class="form-group">
		              	{!! Form::open(['url' => '#']) !!}
    
			                {!! Form::label('type_id' , 'Type')!!}
			                
			                {!! Form::select('type_id' ,  $inputs , 0 , ['class' => 'form-control select' , 'placeholder' => 'Choose One' , 'style' =>"width: 100%;" ]) !!}
 			                

						{!! Form::close() !!}
		              </div>

		              <div class="form-group">
		              	
		              	<form method="post" action="{{ URL::current() }}" class="form-horizontal" id="addAttr">
		              		
		              		{{ csrf_field() }}


		              	</form>
		              	
		              </div>
		              <!-- /.form-group -->
		              
		            </div>
		        
		            <!-- /.col -->
		          </div>
		          <!-- /.row -->
		 

              <div class="modal-footer">
                <button type="button" class="btn btn-outline pull-left closeForm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline add">Add</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>

	</div>