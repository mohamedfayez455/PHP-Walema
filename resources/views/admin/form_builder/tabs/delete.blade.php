<div class="modal modal-info fade" id="delete-{{$ids[$i]}}">
		        <div class="modal-dialog">
		            <div class="modal-content">
		              <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                  <span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title">Delete Field</h4>
		              </div>

		              <div class="modal-body">

				          <div class="row">
				            <div class="col-md-12">
				              <div class="form-group">
				              	{!! Form::open(['url' =>  $url .'/' . $ids[$i] , 'method' => 'POST' , 'id' =>'deleteForm-'. $ids[$i] ]) !!}
		    						
				              		<h3 class="alert alert-danger">Do You Want To Remove it ?</h3>

		    						{{ method_field('DELETE') }}
								{!! Form::close() !!}
				              
				            </div>
				        
				            <!-- /.col -->
				          </div>
				          <!-- /.row -->
				 

		              <div class="modal-footer">
		                <button type="button" class="btn btn-outline pull-left closeForm" data-dismiss="modal">Close</button>
		                <button type="button" class="btn btn-outline btn-danger sure-{{$ids[$i]}}">Sure</button>
		              </div>
		            </div>
		            <!-- /.modal-content -->
		          </div>
		          <!-- /.modal-dialog -->
		        </div>

			</div>
</div>