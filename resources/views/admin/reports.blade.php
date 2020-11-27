@extends('admin.index')


@section('content')




      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All Reports</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th>ID</th>
                  <th>Email</th>
                  <th>Listing</th>
                  <th>Reason</th>
                </tr>
                @foreach($reports as $report)
                <tr>
                  <td>{{ $report->id }}</td>
                  <td>{{ $report->email }}</td>
                  <td><span class="label label-success">{{ $report->listing }}</span></td>
                  <td>{{ $report->reason }}</td>
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