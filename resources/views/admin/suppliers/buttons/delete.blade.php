<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#del_admin{{ $id }}"><i class="fa fa-trash"></i></button>

<div id="del_admin{{ $id }}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Supplier</h4>
      </div>
      {!! Form::open(['route'=>['suppliers.destroy',$id],'method'=>'DELETE']) !!}
      <div class="modal-body">
        <h4 class="alert-danger alert">Do You Want To Remove It ?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
        {!! Form::submit('Yes',['class'=>'btn btn-danger']) !!}
      </div>
      {!! Form::close() !!}
    </div>

  </div>
</div>