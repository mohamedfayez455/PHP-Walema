<div class="modal modal-info fade" id="edit-{{$ids[$i]}}">
		        <div class="modal-dialog">
		            <div class="modal-content">
		              <div class="modal-header">
		                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                  <span aria-hidden="true">&times;</span></button>
		                <h4 class="modal-title">Edit Field</h4>
		              </div>
		              <div class="modal-body">

				          <div class="row">
				            <div class="col-md-12">
				              

				              <div class="form-group">
				              	
				              	<form method="POST" action="{{ $url . '/' . $ids[$i] }}" class="form-horizontal" id="EditAttr-{{$ids[$i]}}">
				              		
				              		{{ csrf_field() }}


				              	</form>
				              	
				              </div>
				              <!-- /.form-group -->
				              
				            </div>
				        
				            <!-- /.col -->
				          </div>
				          <!-- /.row -->
				 

		              <div class="modal-footer">
		                <button type="button" class="btn btn-outline pull-left closeFormEdit-{{$ids[$i]}}" data-dismiss="modal">Close</button>
		                <button type="button" class="btn btn-outline edit-{{$ids[$i]}}">Edit</button>
		              </div>
		            </div>
		            <!-- /.modal-content -->
		          </div>
		          <!-- /.modal-dialog -->
		        </div>

		    </div>