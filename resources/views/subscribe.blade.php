<button data-toggle="modal" data-target="#subscribeModal" style="width: 160px;
				    margin-left: 215px;
				    margin-bottom: 30px;
				    padding: 10px;
				    border-radius: 20px;
				    border: none;
				    background-color: rgb(33, 165, 255);
    				color: white;
				    font-weight: bold;">
		Subscribe to our list
	</button>

	<!-- LOGIN  MODAL -->
	  <div id="subscribeModal" tabindex="-1" class="modal fade" role="dialog">
	    <div class="modal-dialog">

	      <!-- Modal content-->
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal">&times;</button>
	          <h4 class="modal-title">Subscribe To Our List</h4>
	        </div>
	        <div class="modal-body">
	          <form id="subscribe_form">
	          	{{ csrf_field() }}
	            <div class="form-group">
	              <i class="fa fa-envelope" aria-hidden="true"></i>
	              <input type="email" value="{{ user()->email ?? '' }}" class="form-control" name="email" placeholder="Email">
	            </div>

	            <div class="form-group">
	              <select name="type" class="form-control">
	              	<option {{ (user()->role ?? '') == 'supplier' ? 'selected' : '' }} value="supplier">Supplier</option>
	              	<option {{ (user()->role ?? '') == 'customer' ? 'selected' : '' }} value="customer">Customer</option>
	              </select>
	            </div>

	            <div class="form-group">
	              <button type="submit" class="btn btn-primary subscribeBtn btn-block">Subscribe</button>
	            </div>

	          </form>
	        </div>
	      </div>

	    </div>
	  </div>