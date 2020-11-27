<!-- Dashboard header -->
  <section class="navbar-dashboard-area supnavbar">
    <nav class="navbar navbar-default lightHeader navbar-dashboard" role="navigation">
      <div class="container">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-dash">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-dash">
          <ul class="nav navbar-nav mr0">
            <li class="active">
              <a href="{{route('dashboard')}}"><i class="fa fa-tachometer icon-dash" aria-hidden="true"></i> Dashboard</a>
            </li>
            <li class="dropdown singleDrop">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-list-ul icon-dash" aria-hidden="true"></i> Listings <i class="fa fa-angle-down" aria-hidden="true"></i></a>
              <ul class="dropdown-menu dropdown-menu-left">
                <li><a href="{{route('suppliers.listings')}}">My Listings</a></li>
                <li><a href="{{route('suppliers.add_listings')}}">Add Listings</a></li>
              </ul>
            </li>

            <li><a href="{{route('dashboard')}}#complaints" class="scrolling"><i class="fa fa-envelope icon-dash" aria-hidden="true"></i>Complaints</a></li>

            <li class="dropdown singleDrop">
              <a href="{{route('suppliersreviwes')}}" class="scrolling"><i class="fa fa-star-o" aria-hidden="true"></i> Reviews</a>
            </li>
            <li><a href="{{route('dashboard')}}#message" class="scrolling"><i class="fa fa-envelope icon-dash" aria-hidden="true"></i> Messages</a></li>
            <li><a href="{{route('supplier.profile' , supplier()->id)}}"><i class="fa fa-user icon-dash" aria-hidden="true"></i>Personal Details</a></li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>

                    {{ supplier()->name }} <i class="fa fa-power-off"></i>

                </a>

                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ route('suppliers.logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('suppliers.logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </section>
