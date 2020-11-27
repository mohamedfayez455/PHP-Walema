<nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              @if( admin()->photo )
                <img src="{{ admin()->photo }}" class="user-image" alt="Admin Image">
              @endif
              <span class="hidden-xs">
                {{ ucfirst( admin()->firstname ) . ' ' . ucfirst( admin()->lastname ) }}
              </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">

                @if( admin()->photo )
                  <img src="{{ admin()->photo }}" class="img-circle" alt="Admin Image">
                @endif

                <p>
                  {{ ucfirst( admin()->firstname ) . ' ' . ucfirst( admin()->lastname ) }}
                  <small>Member since {{ admin()->created_at->diffForHumans() }} </small>
                </p>
              </li>

              <!-- Menu Footer-->

              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{ route('admin.profile') }}" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>