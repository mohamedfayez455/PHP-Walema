@extends('admin.index')
@section('content')


            <div class="box-header">
              <h3 class="box-title">{{ $title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">

              	<form method="POST" action="">

              		{{ method_field('PUT') }}
              		{{ csrf_field() }}

				  <div class="form-check row" style="margin-bottom:20px">
				    <label class="form-check-label col-lg-2" for="exampleCheck1">Search With Category</label>
				    <input type="checkbox" class="form-check-input col-lg-6" {{ ($record) ? ( $record->search_with_category == 'on'  ? 'checked' :'') : '' }} name="search_with_category">
				  </div>

				  <div class="form-check row" style="margin-bottom:20px">
				    <label class="form-check-label col-lg-2" for="exampleCheck1">Search With Sub Category</label>
				    <input type="checkbox" {{ ($record) ? ( $record->search_with_sub_category == 'on' ? 'checked' :'') : '' }} class="form-check-input col-lg-6" name="search_with_sub_category">
				  </div>


				  <div class="form-check row" style="margin-bottom:20px">
				    <label class="form-check-label col-lg-2" for="exampleCheck1">Search With Type</label>
				    <input type="checkbox" {{ ($record) ? ( $record->search_with_type == 'on' ? 'checked' :'') : '' }} class="form-check-input col-lg-6" name="search_with_type">

				  </div>

				   <div class="form-check row col-lg-2" style="margin-top: 10px">
				    <input type="submit" class="btn btn-primary" value="Save">
				  </div>

				</form>

            </div>

@endsection