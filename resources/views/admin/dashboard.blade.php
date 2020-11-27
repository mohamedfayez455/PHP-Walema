@extends('admin.index')


@section('content')

  @push('css')

    <link rel="stylesheet" type="text/css" href="{{ url('/') }}/admin_design/plugins/vector/jquery-jvectormap-2.0.3.css">

    <link rel="stylesheet" type="text/css" href="{{ url('/')}}/dist/jquery-confirm/jquery-confirm.min.css">

  @endpush

  @push('js')



  <script src="{{ url('/')}}/dist/jquery-confirm/jquery-confirm.min.js"></script>

  <script src="{{ url('/')}}/dist/socket.io-client/socket.io.js"></script>
  <script type="text/javascript" src="{{ url('/dist/locationpicker/locationpicker.jquery.min.js') }}"></script>

  <script src="{{ url('/')}}/js/socket.io.js"></script>

  <script type="text/javascript">

    var admin_id = '{{ admin()->id }}';
    var name = '{{ admin()->name }}';
    var user_image="";

    var my_friends = [];

    var active_suppliers = [];
    var active_customers = [];
    var currentSupCode = '';
    var currentConCode = '';

    var socket = io.connect(chatURL , {

      query: 'admin_id=' + admin_id + '&name=' + name + '&user_image=' + user_image +'&my_friends=' + my_friends+'&role=' + 'admin'

     });

     function ifOnline(uid , type) {
      socket.emit('check_if_online' , {user_id: 'user_' + uid , type:type});
    }
  </script>


    <script src="{{ url('/') }}/admin_design/plugins/vector/jquery-jvectormap-2.0.3.min.js"></script>

    <script src="{{ url('/') }}/admin_design/plugins/vector/jquery-jvectormap-world-mill.js"></script>


    <script type="text/javascript">

      var countries ={};
      $.ajax({
        url: "{{ url('/get-all-country') }}",
        type: 'GET',
        dataType: 'json',
      })
      .done(function(response) {
        countries = response;
      });


      jQuery(document).ready(function() {

        $('#vmap1').vectorMap({
          map: 'world_mill',
          onRegionOver  : function(el, code){
            $('.suppliers .country').html( countries[code] );

          },
          onRegionClick: function(event, code)
            {
              var newSupCode = code.trim();

              if ( currentSupCode != newSupCode ) {

                $.ajax({
                  url: "{{ url('/suppliers') }}/" + newSupCode,
                  type: 'get',
                  dataType: 'json',
                })
                .done(function(response) {

                  var suppliers = response;

                  $('.number_of_suppliers').html( suppliers.length );

                 active_suppliers = [];
                $('.number_of_active_suppliers').html( active_suppliers.length );

                  for (var i = 0; i < suppliers.length; i++) {

                    var uid = suppliers[i].id;

                    if(! active_suppliers["user_" + uid] ) {
                      ifOnline( uid , 'supplier' );
                    };

                  }

                  currentSupCode = newSupCode;


                })
                .fail(function() {
                  console.log("error");
                });
              }
            }
      });

        $('#vmap2').vectorMap({
          map: 'world_mill',
            onRegionOver: function(el, code){

              $('.customers .country').html( countries[code] );

            },
            onRegionClick: function(event, code)
            {
              var newConCode = code.trim();

              if ( currentConCode != newConCode ) {

                $.ajax({
                  url: "{{ url('/customers') }}/" + newConCode,
                  type: 'get',
                  dataType: 'json',
                })
                .done(function(response) {

                  var customers = response;

                  $('.number_of_customers').html( customers.length );

                 active_customers = [];
                $('.number_of_active_customers').html( active_customers.length );

                  for (var i = 0; i < customers.length; i++) {

                    var uid = customers[i].id;

                    if(! active_customers["user_" + uid] ) {
                      ifOnline( uid , 'customer' );
                    };

                  }

                  currentConCode = newConCode;


                })
                .fail(function() {
                  console.log("error");
                });
              }
            }

        })


        $('.emailBtn').on('click', function(e) {


          var email_to = $('#email_email_to').val();
          var subject = $('#email_subject').val();
          var message = $('#email_message').val();

          $.confirm({
            title: 'sending',
            content: 'Are You Sure ?',
            type: 'blue',
            typeAnimated: true,
            buttons: {
                ok: {
                    text: 'Ok',
                    btnClass: 'btn-blue',
                    action: function(){

                      $.ajax({
                        url: "{{ url('/admin/send/quick-emails') }}",
                        type: 'GET',
                        dataType: 'json',
                        data: {
                          email_to:email_to,
                          subject: subject,
                          message: message,
                        },
                      })
                      .done(function() {
                        $.alert({
                            title: 'Sending',
                            content: 'Your Email Is Sent !',
                        });

                          $('#email_email_to').val('');
                          $('#email_subject').val('');
                          $('#email_message').val('');

                      })
                      .fail(function() {
                        $.alert({
                            title: 'Error!',
                            content: 'UnExpected Error!',
                        });

                      });

                    }
                },
                close: function () {

                }
            }
          });




        });


      });







    </script>


  @endpush
  <!-- Content Wrapper. Contains page content -->

    <!-- Content Header (Page header) -->


    <!-- Main content -->
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ count(App\Supplier::all() ) }}</h3>

              <p>All Suppliers</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ count(App\Customer::all() ) }}</h3>

              <p>All Customer</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>{{ count(App\Listing::all() ) }}</h3>

              <p>All Listing</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ count(App\SupplierReview::all() ) + count(App\CustomerReview::all() ) }}</h3>

              <p>All Reviews</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-6 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="box box-solid bg-light-blue-gradient suppliers">
            <div class="box-header">
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip"
                        title="Date range">
                  <i class="fa fa-calendar"></i></button>
                <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse"
                        data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
                  <i class="fa fa-minus"></i></button>
              </div>
              <!-- /. tools -->

              <i class="fa fa-map-marker"></i>

              <h3 class="box-title">
                Suppliers
              </h3>

              <h2 style="margin-left: 160px;font-weight: bold;font-size: 20px;" class="box-title country">
              </h2>

            </div>
            <div class="box-body">
              <div id="vmap1" style="height: 250px; width: 100%;"></div>
            </div>
            <!-- /.box-body-->
            <div class="box-footer no-border">
              <div class="row">
                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                  <h2 style="color: #000" class="number_of_suppliers">0</h2>
                  <div class="knob-label">Suppliers</div>
                </div>

                <!-- ./col -->
                <div class="col-xs-4 text-center">
                  <h2 style="color: #000" class="number_of_active_suppliers">0</h2>
                  <div class="knob-label">Active Suppliers</div>
                </div>
                <!-- ./col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
          <!-- /.nav-tabs-custom -->


          <!-- quick email widget -->
          <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-envelope"></i>

              <h3 class="box-title">Quick Email</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
              <!-- /. tools -->
            </div>
            <div class="box-body">
              <form action="#" method="post">
                <div class="form-group">
                  <input type="email" class="form-control" id="email_email_to" placeholder="Email to:">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="email_subject" placeholder="Subject">
                </div>
                <div>
                  <textarea class="textarea" id="email_message" placeholder="Message"
                            style="width: 100%; height: 125px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"></textarea>
                </div>
              </form>
            </div>
            <div class="box-footer clearfix">
              <button type="button" class="pull-right btn btn-default emailBtn" id="sendEmail">Send
                <i class="fa fa-arrow-circle-right"></i></button>
            </div>
          </div>

        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-6 connectedSortable">

          <!-- Map box -->
          <div class="box box-solid bg-light-blue-gradient customers">
            <div class="box-header">
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip"
                        title="Date range">
                  <i class="fa fa-calendar"></i></button>
                <button type="button" class="btn btn-primary btn-sm pull-right" data-widget="collapse"
                        data-toggle="tooltip" title="Collapse" style="margin-right: 5px;">
                  <i class="fa fa-minus"></i></button>
              </div>
              <!-- /. tools -->

              <i class="fa fa-map-marker"></i>

              <h3 class="box-title">
                Customers
              </h3>

              <h2 style="margin-left: 160px;font-weight: bold;font-size: 20px;" class="box-title country">
              </h2>

            </div>
            <div class="box-body">
              <div id="vmap2" style="height: 250px; width: 100%;"></div>
            </div>
            <!-- /.box-body-->
            <div class="box-footer no-border">
              <div class="row">
                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                  <h2 style="color: #000" class="number_of_customers">0</h2>
                  <div class="knob-label">Customers</div>
                </div>

                <!-- ./col -->
                <div class="col-xs-4 text-center">
                  <h2 style="color: #000" class="number_of_active_customers">0</h2>
                  <div class="knob-label">Active Customers</div>
                </div>
                <!-- ./col -->
              </div>
              <!-- /.row -->
            </div>



          </div>
          <!-- /.box -->


        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    <!-- /.content -->


  @endsection