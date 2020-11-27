@extends('admin.index')

@push('js')

	<script>

		$('.filter_by').on('change', function(e) {

			window.location.href = '{{ URL::Current() }}/?filter_by=' + $(this).val();

		});

	</script>

@endpush

@section('content')




      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Mailling List</h3>
              <form>
                <select name="filter_by" class="pull-right filter_by" style="margin-right: 30px;margin-top: 0px;">
              	<option {{ request('filter_by') == 'all' ? 'selected' : '' }} value="all">All</option>
              	<option {{ request('filter_by') == 'supplier' ? 'selected' : '' }} value="supplier">Supplier</option>
              	<option {{ request('filter_by') == 'customer' ? 'selected' : '' }} value="customer">Customer</option>
              	</select>
              </form>
            </div>
            <!-- /.box-header -->

            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th>#</th>
                  <th>Email</th>
                  <th>Type</th>
                </tr>
                @foreach($members as $i => $member)
                <tr>
                  <td>{{ $i + 1  }}</td>
                  <td>{{ $member['email_address'] }}</td>
                  <td>{{ $member['type'] }}</td>
                </tr>
                @endforeach
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>

    <!-- /.content -->


  @endsection