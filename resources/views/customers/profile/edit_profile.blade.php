
@extends('layouts.app')

@section('content')


@push('css')
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/dist/select2/css/select2.min.css">
@endpush

@push('js')

<script  src="{{url('/')}}/dist/select2/js/select2.min.js"></script>


<script src="{{url('/')}}/admin_design/js/show_form_builder.js"></script>

<script type="text/javascript">

  jQuery(document).ready(function() {

    var url = '{{ route("front_customers_profile_builder.get_profile_builder") }}/';

    showFormBuilder(url , '.edit_profile' , 'edit_profile' , '.additionalData');

  });

  $('.nav-tabs > li').on('click', function(e) {

    $('script').last().next().remove();

    $('script').last().next().remove();

  });



</script>

@endpush

<!-- Dashboard breadcrumb section -->
<div class="section dashboard-breadcrumb-section">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h2>My Profile</h2>
        <ol class="breadcrumb">
          <li><a href="/">Home</a></li>
          <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
          <li class="active">My Profile</li>
        </ol>
      </div>
    </div>
  </div>
</div>


<!-- DASHBOARD PROFILE SECTION -->
<section class="clearfix profileSection">
  <div class="container" style="padding: auto">
    <div class="row">


<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">

              <li class="active"><a href="#edit_profile" data-toggle="tab">Edit Profile</a></li>
              <li><a href="#update_password" data-toggle="tab">Update Password</a></li>

            </ul>
            <div class="tab-content" style="padding: 10px;margin:10px">


              <div class="active tab-pane" id="edit_profile">

                <div class="box-body">

                   <form enctype="multipart/form-data" action="{{ route('customer.do_customer_edit_Profile') }}" class="edit_profile" method="POST">
                    {{ csrf_field() }}
                  </form>
                </div>

              </div>
              <div class="tab-pane" id="update_password">

                <div class="box-body">

                <form class="form-horizontal" method="POST" action="{{ route('user.update_password') }}" enctype="multipart/form-data">


                  {{ csrf_field()  }}
                  {{ method_field('PUT') }}

                  <div class="form-group">
                    <label for="current_password" class="col-sm-2 control-label">Password</label>

                    <div class="col-sm-10">
                      <input type="password" name="current_password" class="form-control" id="current_password" placeholder="Password">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="new_password" class="col-sm-2 control-label">New Password</label>

                    <div class="col-sm-10">
                      <input type="password" name="new_password" class="form-control" id="new_password" placeholder="New Password">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="confirmation_password" class="col-sm-2 control-label">Confirmation Password</label>

                    <div class="col-sm-10">
                      <input type="password" name="confirmation_password" class="form-control" id="confirmation_password" placeholder="Confirmation Password">
                    </div>
                  </div>


                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                  </div>

                </form>
                </div>
              </div>

              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
</div>
    </div>
  </div>
</section>


  </div>

@endsection
