<!DOCTYPE html>
<html lang="en">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<head>

  <!-- SITE TITTLE -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> {{ app_name() }} </title>

  <!-- PLUGINS CSS STYLE -->
  <link href="{{asset('plugins/jquery-ui/jquery-ui.min.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/listtyicons/style.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/bootstrapthumbnail/bootstrap-thumbnail.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/datepicker/datepicker.min.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/selectbox/select_option1.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/owl-carousel/owl.carousel.min.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/slick/slick.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/slick/slick-theme.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/fancybox/jquery.fancybox.min.css')}}" rel="stylesheet"/>
  <link href="{{asset('plugins/isotope/isotope.min.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/map/css/map.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/rateyo/jquery.rateyo.min.css')}}" rel="stylesheet">
  <link href="{{asset('plugins/animate/animate.css')}}" rel="stylesheet">

  <!-- GOOGLE FONT -->
  <link href="https://fonts.googleapis.com/css?family=Muli:200,300,400,600,700,800,900" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Herr+Von+Muellerhoff" rel="stylesheet">

  <!-- CUSTOM CSS -->
  <link href="{{asset('css/style.css')}}" rel="stylesheet">

  <link rel="stylesheet" href="{{asset('css/default.css')}}" id="option_color">

  <!-- FAVICON -->


  @stack('css')

  @if( setting()->icon )
    <link href="{{ Storage::url(setting()->icon) }}" rel="shortcut icon">
  @else
    <link href="{{ Storage::url(setting()->icon) }}" rel="shortcut icon">
  @endif

  <!--
    HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries

   -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->


</head>

<body id="body" class="body-wrapper boxed-menu" >
  <!-- <div class="page-loader" style="background: url(img/preloader.gif) center no-repeat #fff;"></div> -->
  <!-- Preloader -->
	<div id="preloader" class="smooth-loader-wrapper">
		<div class="smooth-loader">
			<div class="loader1">
			<div class="loader-target">
				<div class="loader-target-main"></div>
				<div class="loader-target-inner"></div>
				</div>
			</div>
		</div>
	</div>
  <div class="main-wrapper">
    <!-- HEADER -->

    <header id="pageTop" class="header">

      <!-- TOP INFO BAR -->

      <div class="nav-wrapper navbarWhite">
        <!-- NAVBAR -->
        <nav id="menuBar" class="navbar navbar-default lightHeader animated " role="navigation">
          <div class="container" style="float: left">

            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header" style="margin-left: 8px">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="{{ asset('/') }}">
               <img style="width: 120px;height: 110px;margin-top: -37px" src="{{ Storage::url(setting()->icon) }}" class="img-responsive">
              </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse" style="font-size: 16px;width: 1300px">
              @if( is_guest() )

                <ul class="nav navbar-nav navbar-right" style="width:100%;;left:260px;position: absolute;">

                  <li class="pull-left">
                    <a style="padding: 40px 0 0 20px" href="{{url('/')}}" >home </a>
                  </li>

                  <li class="pull-left" >
                        <a style="padding: 40px 0 0 20px" href="{{route('suppliers_list')}}" >Suppliers</a>
                  </li>

                  <li class="pull-right" style="margin-top: 30px;">
                    <a id="con" class="nav-links" style="padding:11px;border-radius: 20px;margin-right: 10px;color:#fff;background-color: rgb(33, 165, 255);" href="{{route('customers.register')}}" >Signup as Customer</a>
                  </li>

                  <li class="pull-right" style="margin-top: 30px;" >
                    <a id="sup" class="nav-links" style="padding:11px;border-radius: 20px;margin-right: 10px;color:#fff;background-color: rgb(33, 165, 255);" href="{{route('suppliers.register')}}" >Signup as Supplier</a>
                  </li>

                  <li class="pull-right" style="margin-top: 30px;">
                    <a id="login" class="nav-links" style="padding:11px;border-radius: 20px;margin-right: 10px;color:#fff;background-color: rgb(33, 165, 255);" href="{{ asset('/login') }}" >Login</a>
                  </li>


                  <li>
                    <a href="{{route('about_us')}}" >About us </a>
                  </li>

                  <li>
                    <a style="padding: 40px 0 0 20px" href="{{route('contact')}}" >Contact us </a>
                  </li>

                </ul>
              @else
                <ul class="nav navbar-nav navbar-left" style="margin-left: 200px">

                      <li >
                        <a href="{{url('/')}}" >home </a>
                      </li>


                      @if( is_supplier() || is_customer() )

                       <li>
                          <a href="{{route('dashboard')}}" >Dashboard</a>
                        </li>
                      @endif

                      @if( is_supplier() )

                        <li>
                          <a href="{{route('supplier.profile',supplier()->id )}}" >Profile</a>
                        </li>

                      @endif

                      @if( is_customer() )

                      <li>
                        <a href="{{route('customer.profile',customer()->id )}}" >Profile</a>
                      </li>

                      <li>
                        <a href="{{route('suppliers_list')}}" >Suppliers</a>
                      </li>
                      @endif

                      <li>
                        <a href="{{route('about_us')}}" >About us </a>
                      </li>

                      <li>
                        <a href="{{route('contact')}}" >Contact us </a>
                      </li>

                </ul>


              @endguest
            </div>


            </div>

            @if( is_authenticated()  )

            <ul style="float: right;margin-right: 300px;margin-top: 10px;z-index:9999999">
                  <li class="dropdown login">
                        <a href="#" class="dropdown-toggle loginLink" data-toggle="dropdown">

                          @if( is_supplier() )

                            @if( supplier_photo() )
                              <img class="user_img" src="{{ supplier_photo() }}" style="border-radius: 50%" width="70px" height="70px" class="user-image" alt="User Image">
                            @else
                              <img class="user_img" src="{{ asset('/img/default_supplier.jpg') }}" width="70px" height="70px" class="user-image" alt="User Image">
                            @endif

                          @elseif( is_customer() )

                            @if( customer_photo() )
                              <img class="user_img" src="{{ customer_photo() }}" style="border-radius: 50%" width="70px" height="80px" class="user-image" alt="User Image">
                            @else
                              <img class="user_img" src="{{ asset('/img/default_user.png') }}" width="70px" height="70px" class="user-image" alt="User Image">
                            @endif


                          @endif

                        </a>

                        <ul class="dropdown-menu proftle_card" style="padding: 10px;background-color:white;color: #3c8dbc;width: 330px;position: absolute;top: 78px;left:-260px;border-radius: 30px;">

                          <!-- User image -->
                          <li class="dropdown-item" style="text-align: center">

                            @if( is_supplier() )

                            @if( supplier_photo() )
                              <img class="user_img" src="{{ supplier_photo() }}" style="border-radius: 50%" width="70px" height="70px" class="user-image" alt="User Image">
                            @else
                              <img class="user_img" src="{{ asset('/img/default_supplier.jpg') }}" width="70px" height="70px" class="user-image" alt="User Image">
                            @endif

                            <p style="color #3c8dbc;">
                               <span class="badge">
                                {{ ucfirst( supplier()->name ) }}
                              </span>
                              <small style="display: block;color:#222;"> {{ supplier()->user->email }} </small>
                            </p>



                          @elseif( is_customer() )

                            @if( customer_photo() )
                              <img class="user_img" src="{{ customer_photo() }}" style="border-radius: 50%" width="70px" height="70px" class="user-image" alt="User Image">
                            @else
                              <img class="user_img" src="{{ asset('/img/default_user.png') }}" width="70px" height="70px" class="user-image" alt="User Image">
                            @endif

                            <p style="color #3c8dbc;">
                              <span class="badge">
                              {{ ucfirst( customer()->name ) }}
                            </span>
                              <small style="display: block;color:#222;"> {{ customer()->user->email }} </small>
                            </p>


                          @endif


                          </li>

                          <!-- Menu Footer-->

                          <li class="dropdown-item">

                            @if( is_supplier() )
                              <div class="pull-left">
                                <a href="{{ route('supplier.supplier_edit_Profile') }}"style="color:#3c8dbc;padding: 5px;font-size: 13px;"  class="btn btn-default">Edit Profile</a>
                              </div>

                              <div>
                                <a href="{{ route('suppliers.add_listings') }}"style="color:#3c8dbc;padding: 5px;margin-left: 8px;font-size: 13px;"  class="btn btn-default">Add Listing</a>
                              </div>


                              <div class="pull-right" style="margin-top: -22px;">
                                <a href="{{ route('suppliers.logout') }}" style="color:#3c8dbc;padding: 5px;    font-size: 13px;" class="btn btn-default"onclick="event.preventDefault();
                                     document.getElementById('suppliers-form').submit();">Log out</a>
                              </div>

                             @elseif( is_customer() )
                              <div class="pull-left">
                                <a href="{{ route( 'customer.customer_edit_Profile') }}"style="color:#3c8dbc;padding: 5px;font-size: 13px;"  class="btn btn-default">Edit Profile</a>
                              </div>
                              <div class="pull-right">
                                <a href="{{ route('customers.logout') }}" style="color:#3c8dbc;padding: 5px;    font-size: 13px;" class="btn btn-default" onclick="event.preventDefault();
                                     document.getElementById('customers-form').submit();">
                                   Log out</a>
                              </div>
                             @endif

                             <form id="suppliers-form" action="{{ route('suppliers.logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>

                            <form id="customers-form" action="{{ route('customers.logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>

                          </li>
                        </ul>
                  </li>
              </ul>

            @endif

          </nav>
      </div>
    </header>

    @include('admin.layouts.messages')