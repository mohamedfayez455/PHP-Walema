@extends('admin.index')


@section('content')




      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Contact Us Message</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tbody><tr>
                  <th>ID</th>
                  <th>Subject</th>
                  <th>name</th>
                  <th>email</th>
                  <th>content</th>
                </tr>
                @foreach($contacts as $contact)
                <tr>
                  <td>{{ $contact->id }}</td>
                  <td>{{ $contact->subject }}</td>
                  <td>{{ $contact->name }}</td>
                  <td>{{ $contact->email }}</td>
                  <td>{{ $contact->content }}</td>
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