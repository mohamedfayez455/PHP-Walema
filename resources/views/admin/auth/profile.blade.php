@extends('admin.index')

@section('content')

        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">

              @if( admin()->photo )
                  <img src="{{ admin()->photo }}" class="profile-user-img img-responsive img-circle" alt="User profile picture">
              @endif


              <h3 class="profile-username text-center"> {{ ucfirst( admin()->firstname ) . ' ' . ucfirst( admin()->lastname ) }}  </h3>

              <p class="text-muted text-center">Admin</p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Username</b> <a class="pull-right"> {{ admin()->username }} </a>
                </li>

                <li class="list-group-item">
                  <b>Email</b> <a class="pull-right">{{ admin()->email }}</a>
                </li>

              </ul>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">

              <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
              <li><a href="#update_password" data-toggle="tab">Update Password</a></li>

            </ul>
            <div class="tab-content">


              <div class="active tab-pane" id="settings">

                <div class="box-body">

                <form class="form-horizontal" method="POST" action="{{ route('admins.update' , admin()->id ) }}" enctype="multipart/form-data">


                  {{ csrf_field()  }}
                  {{ method_field('PUT') }}

                  <div class="form-group">
                    <label for="firstname" class="col-sm-2 control-label">Firstname</label>

                    <div class="col-sm-10">
                      <input type="text" value="{{ admin()->firstname }}" name="firstname" class="form-control" id="firstname" placeholder="Firstname">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="lastname" class="col-sm-2 control-label">Lastname</label>

                    <div class="col-sm-10">
                      <input type="text" value="{{ admin()->lastname }}" name="lastname" class="form-control" id="lastname" placeholder="Lastname">
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" value="{{ admin()->email }}" name="email" class="form-control" id="email" placeholder="Email">
                    </div>
                  </div>


                  @if(admin()->photo)
                    <div class="form-group">

                      <div class="col-sm-offset-2 col-sm-10">
                        <img src="{{ admin()->photo }}" width="50px" height="50px">
                      </div>

                    </div>

                  @endif

                  <div class="form-group">

                  <label for="i,age" class="col-sm-2 control-label">Photo</label>

                    <div class="col-sm-10">
                      <input type="file" class="form-control" name="photo" id="inputName" placeholder="Image">
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
            <div class="tab-pane" id="update_password">

                <div class="box-body">

                <form class="form-horizontal" method="POST" action="{{ route('admins.update_password') }}" enctype="multipart/form-data">


                  {{ csrf_field()  }}
                  {{ method_field('PUT') }}

                  <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Password</label>

                    <div class="col-sm-10">
                      <input type="password" name="password" class="form-control" id="password" placeholder="Password">
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
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
@endsection