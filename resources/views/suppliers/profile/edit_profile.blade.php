
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

    var url = '{{ route("front_suppliers_profile_builder.get_profile_builder") }}/';

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
              <li><a href="#edit_listing" data-toggle="tab">Edit Listing</a></li>

            </ul>
            <div class="tab-content" style="padding: 10px;margin:10px">


              <div class="active tab-pane" id="edit_profile">

                <div class="box-body">

                   <form enctype="multipart/form-data" action="{{ route('supplier.do_supplier_edit_Profile') }}" class="edit_profile" method="POST">
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

              <div class="tab-pane" id="edit_listing">

                <div class="col-xs-12">
                    <div class="dashboardPageTitle">
                      <h2>My Listings</h2>
                    </div>
                    <div class="table-responsive"  data-pattern="priority-columns">
                      @if( $number_of_listings > 0 )
                        <table class="table listingsTable">
                          <thead>
                            <tr class="rowItem">
                              <th data-priority="">Listings</th>
                              <th data-priority="6">Views</th>
                              <th data-priority="2">Reviews</th>
                              <th data-priority="3">Posted on</th>
                              <th data-priority="4">Last Edited</th>
                              <th data-priority="5">Status</th>
                              <th data-priority="7">Edit</th>
                              <th data-priority="7">Delete</th>
                            </tr>
                          </thead>
                          <tbody>

                            @forelse($listings as $listing)
                            <tr class="rowItem">
                              <td>
                                <ul class="list-inline listingsInfo">
                                  @if($listing->main_photo)
                                  <li><a href=" {{ route('listings.show' , $listing->id) }}"><img src="{{ Storage::url($listing->main_photo) }}" width="250px" height="130px" alt="Image Listings"></a></li>
                                  @else
                                  <li><a href=" {{ route('listings.show' , $listing->id) }}"><img src="{{asset('img/dashboard/listing.jpg')}}" alt="Image Listings"></a></li>
                                  @endif
                                  <li>
                                    <h3><a href=" {{ route('listings.show' , $listing->id) }} "> {{$listing->name}} <i class="fa fa-check-circle" aria-hidden="true"></i> </a> </h3>
                                    <h5>
                                      {{ substr($listing->description , 0 , 45) }}
                                    </h5>
                                    <h5>
                                      <span class="cityName">{{ $listing->city }}</span>
                                    </h5>
                                    <span class="category">{{$listing->category->name}}</span>

                                    <p>${{$listing->price}}
                                      <span class="likeArea liking" id="{{ $listing->id }}">
                                        <i class="fa fa-heart-o {{ ( user()->is_user_liked_listing($listing->id) ) ? 'active':'' }}" aria-hidden="true"></i>
                                        <span class="number{{ $listing->id }}"> {{$listing->likes()->count()}}</span>
                                        <?=($listing->likes()->count()) >= 1000 ? ($listing->likes()->count() >= 1000000 ? 'm' : 'k') : ''?>
                                      </span>
                                    </p>

                                  </li>
                                </ul>


                              </td>

                              <td>{{ count( $listing->visits() ) }}</td>
                              <td>
                                <ul class="list-inline rating">
                                  @for($i = 1 ; $i <= 5 ; $i++)
                                    <li><i class="fa {{ $i<= round($listing->review()) ? 'fa-star' : 'fa-star-o' }} " data-value="{{ $i }}" aria-hidden="true"></i></li>
                                  @endfor
                                  <li>{{ round($listing->review())  }}</li>
                                </ul>

                              </td>

                               <td>{{$listing->created_at->diffForHumans()}}</td>
                                <td>{{$listing->updated_at->diffForHumans()}}</td>
                                <td><span class="label {{$listing->status == 'active' ? 'label-success' : ( $listing->status == 'canceled' ? 'label-danger' : 'label-warning' ) }}">{{$listing->status}}</span></td>

                              <td style="width: 100px">
                                <a style="width: 100%" href="{{ route('suppliers.store_listing' , $listing->id) }}"> <i class="fa fa-edit"></i> Edit</a>
                              </td>

                              <td style="width: 100px">

                                <a style="width: 100%" href="{{ route('suppliers.delete_listing' , $listing->id) }}" onclick="event.preventDefault();document.getElementById('delete-listing-form').submit();">
                                  <i class="fa fa-trash"></i> Delete
                                </a>


                              <form id="delete-listing-form" action="{{ route('suppliers.delete_listing' , $listing->id) }}" method="POST" style="display: none;">
                                  {{ csrf_field() }}
                               </form>

                              </td>

                            </tr>
                            @empty
                            <tr> <h3 class="text-danger text-center"> There Are No Listings To Appear </h3></tr>
                            @endforelse


                          </tbody>
                        </table>
                      @else

                        <h3 class="text-info text-center"> There Are No Listings To Appear
                        </h3>

                      @endif

                    </div>
                    <div class="paginationCommon blogPagination text-center">
                      <nav aria-label="Page navigation">
                        <ul class="pagination">

                          {{ $listings->links() }}

                        </ul>
                      </nav>
                    </div>
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
