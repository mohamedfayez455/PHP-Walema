<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          @if( admin()->photo )
          <img src="{{ admin()->photo }}" class="img-circle" alt="User Image">
          @endif
        </div>
        <div class="pull-left info">
          <p> {{ ucfirst( admin()->firstname ) . ' ' . ucfirst( admin()->lastname ) }} </p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview {{ active('')[0] }} ">
          <a>
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>

          <ul class="treeview-menu">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-users"></i> Dashboard </a></li>

            <li><a href="{{ route('dashboard.reports') }}"><i class="fa fa-users"></i> Reports </a></li>

            <li><a href="{{ route('dashboard.newsletter') }}"><i class="fa fa-users"></i> Newsletter </a></li>


            <li><a href="{{ route('dashboard.listings') }}"><i class="fa fa-users"></i> Listings </a></li>

          </ul>

        </li>

        <li class="treeview {{ active('admins')[0] }} ">
          <a href="#">
            <i class="fa fa-users" aria-hidden="true"></i>
            <span>Admins</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

            <li><a href="{{ route('admins.index') }}"><i class="fa fa-users"></i> Admins </a></li>
            <li><a href="{{ route('admins.create') }}"><i class="fa fa-plus"></i> Add </a></li>

          </ul>
        </li>

        <li class="treeview {{ active('suppliers')[0] }}">
          <a href="#">
            <i class="fa fa-users" aria-hidden="true"></i>
            <span>Suppliers</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('suppliers.index') }}"><i class="fa fa-users"></i> Suppliers </a></li>
            <li><a href="{{ route('suppliers.create') }}"><i class="fa fa-plus"></i> Add </a></li>
          </ul>
        </li>



       <li class="treeview {{ active('customers')[0] }}">
          <a href="#">
            <i class="fa fa-users" aria-hidden="true"></i>
            <span>Customers</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('customers.index') }}"><i class="fa fa-users"></i> Customers </a></li>
            <li><a href="{{ route('customers.create') }}"><i class="fa fa-plus"></i> Add </a></li>
          </ul>
        </li>

      <li class="treeview {{ active('supplier-categories')[0] }}">
          <a href="#">
            <i class="fa fa-list" aria-hidden="true"></i>
            <span>Suppliers Categories</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('supplier-categories.index') }}"><i class="fa fa-flag"></i> Supplier Categories </a></li>
            <li><a href="{{ route('supplier-categories.create') }}"><i class="fa fa-plus"></i> Add </a></li>
          </ul>
        </li>

      <li class="treeview {{ active('form_builder')[0] }}">
          <a href="#">
            <i class="fa fa-edit" aria-hidden="true"></i>
            <span>Form Builders</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('suppliers_profile_builder.edit_form_builder') }}"><i class="fa fa-edit"></i>Suppliers Profile Builder</a></li>

            <li><a href="{{ route('customers_profile_builder.edit_form_builder') }}"><i class="fa fa-edit"></i>Customers Profile Builder</a></li>

            <li><a href="{{ route('enquiry_form_builder.edit_form_builder') }}"><i class="fa fa-edit"></i>Enquiry Builder</a></li>

          </ul>
        </li>


        <li class="treeview {{ active('cms')[0] }}">
          <a href="#">
            <i class="fa fa-edit" aria-hidden="true"></i>
            <span>CMS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
           <li><a href="{{route('admin.contact_us')}}"><i class="fa fa-circle-o text-red"></i> <span>Contact Us</span></a></li>

          </ul>
        </li>


        <li class="treeview {{ active('supplier-advanced-search')[0] }}">
          <a href="#">
            <i class="fa fa-edit" aria-hidden="true"></i>
            <span> Supplier Advanced Filter </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('settings.supplier_advanced_filter') }}"><i class="fa fa-edit"></i> Supplier Advanced Filter </a></li>

          </ul>
        </li>


      <li class="treeview {{ active('settings')[0] }}">
          <a href="#">
            <i class="fa fa-cog" aria-hidden="true"></i>
            <span>Setting</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{ route('settings.index') }}"><i class="fa fa-edit"></i>Setting</a></li>
          </ul>
        </li>




      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>