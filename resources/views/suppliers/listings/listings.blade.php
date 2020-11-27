@extends('layouts.app')

@section('content')

@push('js')

<script type="text/javascript">

  $('.liking').on('click', function(e) {

      var id = $(this).attr('id');

      var LikedUrl = '{{ url('listings/like') }}/' + id;
      var UnLikedUrl = '{{ url('listings/unlike')}}/' + id;
      var url =  '';


      if ( $(this).children('i').hasClass('active') ) {

        url = LikedUrl;

      }else {

        url = UnLikedUrl;

      }

      var vm = this;

      $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
      })
      .done(function(response) {
        $('.number' + id).html(response.likes);
      })
      .fail(function() {
        console.log("error");
      });


    });

</script>
@endpush

<!-- LISTINGS SECTION -->
<section class="clearfix bg-dark listyPage">
<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="dashboardPageTitle">
        <h2>My Listings</h2>
      </div>
      <div class="table-responsive"  data-pattern="priority-columns">
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
              <h3 class="text-info text-center"> There Are No Listings To Appear </h3>
            @endforelse


          </tbody>
        </table>
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
</div>
</section>

</div>
@endsection()
