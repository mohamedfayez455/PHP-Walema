
@extends('layouts.app')

@section('content')

@push('css')

  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/css/chat.css">
  <link rel="stylesheet" type="text/css" href="{{ url('/')}}/dist/jquery-confirm/jquery-confirm.min.css">

@endpush


@push('js')

    <script src="{{ url('/')}}/dist/jquery-confirm/jquery-confirm.min.js"></script>

    <script src="{{url('/')}}/admin_design/js/show_form_builder.js"></script>

<script type="text/javascript">

  jQuery(document).ready(function() {

    var url = '{{ route("front_enquiry_form_builder.get_profile_builder") }}/';

    showFormBuilder(url , '.edit_enquiry' , 'edit_enquiry' , '.additionalData');

  });

  $('.nav-tabs > li').on('click', function(e) {

    $('script').last().next().remove();

    $('script').last().next().remove();

  });



  $('.liking').on('click', function(e) {

    var LikedUrl = '{{ url('customers/like/'. $supplier->id ) }}';
    var UnLikedUrl = '{{ url('customers/unlike/'. $supplier->id) }}';
    var url =  '';

    if ( $(this).hasClass('like') ) {

      url = LikedUrl;

    }else if ( $(this).hasClass('unlike') ) {

      url = UnLikedUrl;

    }

    var vm = this;

    $.ajax({
      url: url,
      type: 'GET',
      dataType: 'json',
    })
    .done(function(response) {

      if ( response.response == 'liked' ) {
        $(vm).removeClass('like');
        $(vm).addClass('unlike');
        $(vm).html('UnLike');
        $(vm).css('background' , '#F11052');
      }else if (response.response == 'unliked') {
        $(vm).removeClass('unlike');
        $(vm).addClass('like');
        $(vm).html('Like');
        $(vm).css('background' , '#2196f3');
      }

    })
    .fail(function() {
      console.log("error");
    });


  });


  $('.favoriting').on('click', function(e) {

    var LikedUrl = '{{ url('customers/favorite/'. $supplier->id ) }}';
    var UnLikedUrl = '{{ url('customers/unfavorite/'. $supplier->id) }}';
    var url =  '';

    if ( $(this).hasClass('favorite') ) {
      url = LikedUrl;
    }else if ( $(this).hasClass('unfavorite') ) {
      url = UnLikedUrl;
    }

    var vm = this;

    $.ajax({
      url: url,
      type: 'GET',
      dataType: 'json',
    })
    .done(function(response) {

      if ( response.response == 'favorite' ) {
        $(vm).removeClass('favorite');
        $(vm).addClass('unfavorite');
        $(vm).html('Remove From Favorite');
        $(vm).css('background' , '#F11052');
      }else if (response.response == 'unfavorite') {
        $(vm).removeClass('unfavorite');
        $(vm).addClass('favorite');
        $(vm).html('Add To Favorite');
        $(vm).css('background' , '#2196f3');
      }

    })
    .fail(function() {
      console.log("error");
    });


  });




   $(document).on('click', '.send_enquiry' , function(e) {

    e.preventDefault();

    var supplier_email = `<input type='hidden' name='supplier_email' value="{{ user()->email }}">`

    $('.edit_enquiry').append( supplier_email);

    var type = $('select[name="type"]').val();

    var data = $('.edit_enquiry').serialize();

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
                    url: '{{ url('/send/enquiry/' . $supplier->id ) }}',
                    type: 'POST',
                    dataType: 'json',
                    data: data,
                  })
                  .done(function(response) {

                    $.alert({
                        title: 'Sending ' + type.toUpperCase(),
                        content: 'Your '+ type.toUpperCase() + ' Sent !',
                    });


                    $('input[name="name"').val('');
                    $('input[name="email"').val('');
                    $('textarea[name="message"').val('');

                  }).fail(function() {

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

    $('.listing_like').on('click', function(e) {

      var id = $(this).attr('id');

      var LikedUrl = '{{ url('listings/like') }}/' + id;
      var UnLikedUrl = '{{ url('listings/unlike') }}/' + id;
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



      $('.subscribeBtn').on('click', function(e) {

        e.preventDefault();

        var data = $('#subscribe_form').serialize();

         $.confirm({
              title: 'Subscribe List',
              content: 'Subscribing Our List !',
              type: 'blue',
              typeAnimated: true,
              buttons: {
                  ok: {
                      text: 'Ok',
                      btnClass: 'btn-blue',
                      action: function(){

                       $.ajax({
                          url: '{{ url('/newsletter') }}',
                          type: 'POST',
                          dataType: 'json',
                          data:data
                       })
                        .done(function(response) {

                          $.alert({
                              title: 'Subscribe List ',
                              content: 'Success',
                          });

                $('#subscribeModal').modal('hide');

                        }).fail(function() {

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

         return false;

      });

    </script>

@endpush


<!-- Dashboard breadcrumb section -->
<section class="user-profile-section bg-light">
  <div class="container">
    <div class="user-profile">
      <div class="row">
        <div class="col-xs-12 col-sm-4">
          <div class="user-img">
            @if($supplier->avatar)
            <img src="{{ Storage::url($supplier->avatar) }}" alt="User Image" style="width: 220px;height: 220px;">
            @else
            <img src="{{ asset('/img/default_supplier.jpg') }}" alt="User Image" style="width: 220px;height: 220px;">
            @endif
          </div>
        </div>
        <div class="col-xs-12 col-sm-8">
          <div class="user-profile-content">
            <h3 class="user-name">{{ $supplier->name }}</h3>

            <ul class="user-contact-details">
              <li>
                <i class="fa fa-envelope" aria-hidden="true"></i><a href="#">{{ $supplier->user->email }}</a>
              </li>

              @foreach($supplier->profile_data() as $name => $value )

                @if( is_array($value) )
                  <h5 style="color:#848484;margin-top: 10px;margin-bottom: 0px;"> {{ ucfirst($name) }}</h5>

                  <ul class="list-inline" name="{{ ucfirst($name) }}" style="margin-left: 20px;">
                    <li style="color: #2196f3"> {{ implode(', ',  $value) }}</li>
                  </ul>
                @else
                  <li>
                    <span style="font-weight: 1000;font-size: 15px;"> {{ ucfirst($name) }} </span> :
                    <span style="color: #2196f3;">{{ $value }}</span>
                  </li>
                @endif

              @endforeach
            </ul>

            @if( customer() )

            <div style="padding: 10px;" class="verified-user"><i class="fa fa-user-o" aria-hidden="true"></i> {{ ($supplier->verified() ) ? 'Verified Account' : 'Not Verified Account' }}
            </div>

            <div class="verified-user liking {{( customer()->is_customer_liked_supplier($supplier->id) )?'unlike':'like' }}"
            style="background:{{ ( customer() and customer()->is_customer_liked_supplier($supplier->id) ) ? '#F11052' : '#2196f3' }};cursor: pointer;padding: 10px;" >
              <i class="fa fa-user-o" aria-hidden="true"></i>
              {{ ( customer() and customer()->is_customer_liked_supplier($supplier->id) ) ? 'UnLike' : 'Like' }}
            </div>
           <div class="verified-user favoriting {{(customer() and customer()->is_customer_liked_supplier($supplier->id) )?'unfavorite' : 'favorite' }} "
           style="background:{{ ( customer() and customer()->is_customer_liked_supplier($supplier->id) ) ? '#F11052' : '#2196f3' }};cursor: pointer;padding: 10px;" ><i class="fa fa-user-o" aria-hidden="true"></i>
            {{ ( customer() and customer()->is_customer_favorite_supplier($supplier->id) ) ? 'Remove From Favorite' : 'Add To Favorite' }}
            </div>

            <div style="margin-top: -38px;">
              <div user_id='{{ $supplier->user->id }}' user_role="supplier" name='{{ $supplier->name }}' id="side-user-box" user_image="{{ $supplier->avatar }}" style="padding: 10px;color: #2196f3;cursor: pointer;background-color: #fff;border: 1px solid;" class="verified-user messageCommon"><i class="fa fa-envelope" aria-hidden="true"></i> Message
              </div>
            </div>

            @endif
          </div>
        </div>


      </div>
    </div>

      <div class="row">
        <div class="col-sm-4 col-xs-12">
          <div class="panel panel-default panel-card">
        <div class="panel-heading">
          Categories
        </div>
        <div class="panel-body plr">
          <ul class="list-unstyled panel-list">
              @foreach( explode(',' , $supplier->categories ) as $category )
              <li>
                <div class="listWrapper">
                  <div class="listName">
                    <small class="badge">{{ $category }}</small>
                  </div>
                </div>
              </li>
              @endforeach
          </ul>
        </div>
          </div>
        </div>

      </div>

  </div>
  <div class="container">
    <div class="row">
      @if( customer() )
      <div class="col-sm-4">
        <aside>
          <div class="user-contact">
            <h3 class="success"></h3>
            <h3>Enquiry/Complaints</h3>
            <form class="edit_enquiry">

                    {{ csrf_field() }}

            </form>
          </div>
        </aside>
      </div>
      @endif

      <div class="col-sm-8">
        <div class="listContentHeading">
          <h2>{{ ( is_supplier() and supplier()->id == $supplier->id ) ? 'My ' : $supplier->name }} List</h2>
        </div>
        <?php $have_listings = false;?>
        @forelse( $supplier->listings as $listing )
	        @if($listing->status == 'active')
	            <?php $have_listings = true;?>

		        <div class="listContent">
		          <div class="row">
		            <div class="col-sm-5 col-xs-12">
		              <div class="categoryImage">
		                <img src="{{ Storage::url($listing->main_photo) }}" style="width:400px;height:200px" alt="Image category" class="img-responsive img-rounded">
		                <span class="label label-primary">Verified</span>
		              </div>
		            </div>
		            <div class="col-sm-7 col-xs-12">
		              <div class="categoryDetails">
		                <ul class="list-inline rating">
		                  @for($i = 1 ; $i <= 5 ; $i++)
		                    <li>
		                      <i class="fa {{ $i<= round($listing->review()) ? 'fa-star' : 'fa-star-o' }} " data-value="{{ $i }}" aria-hidden="true"></i>
		                    </li>
		                  @endfor
		                </ul>
		                <h2><a href="{{ route('listings.show' , $listing->id) }}" style="color: #222222">{{ $listing->name }}</a>

		                  <span class="likeCount listing_like" id="{{ $listing->id}}">
		                      <i class="fa fa-heart-o {{ ( user()->is_user_liked_listing($listing->id) ) ? 'active':'' }}" aria-hidden="true"></i>
		                      <span style="margin-right: 5px;" class="number{{$listing->id}}">{{ count($listing->likes) }}</span>
		                  </span>
		                </h2>
		                <p>{{ $listing->address }} </p>{{ $listing->description}}. </p>
		                <ul class="list-inline list-tag">
		                  <li><a href="#">{{ $listing->category->name }}</a></li>
		                </ul>
		              </div>
		            </div>
		          </div>
		        </div>
	        @endif
        @endforeach

        @if( $have_listings == false )
          	<li class="text-center text-info">There is No Any Listing</li>
       	@endif



        <div class="row">
          <div class="col-sm-8 col-xs-12">
            <div class="review-aria">
              <div class="listContentHeading">
                <h2>Reviews</h2>
              </div>
              <div class="reviewContent">
                <h3 class="reviewTitle">
                  Reviews {{ count($supplier->SupplierReview) + count( $supplier->CustomerReview  ) }}
                    <span>
                      @for($i = 1 ; $i <= 5 ; $i++)
                        <i class="fa {{ $i<= round($supplier->user->review()) ? 'fa-star' : 'fa-star-o' }} " data-value="{{ $i }}" aria-hidden="true"></i>
                      @endfor
                    </span>
                </h3>

                <div class="reviewMedia">
                  <ul class="media-list">

                    @foreach($supplier->SupplierReview as $review)
                      <li class="media">
                        <div class="media-left">
                          <a href="#">
                            @if( $review->supplier->avatar )
                              <img src="{{ Storage::url($review->supplier->avatar) }}" class="media-object img-circle" alt="Image User">
                            @else
                              <img src="{{ asset('/img/default_supplier.jpg') }}" class="media-object img-circle" alt="Image User">
                            @endif
                          </a>
                        </div>
                        <div class="media-body">
                          <h5 class="media-heading">{{ $review->supplier->name }}</h5>
                          <span>
                            @for($i = 1 ; $i <= 5 ; $i++)
                              <i class="fa {{ $i<= $review->rating ? 'fa-star' : 'fa-star-o' }} " data-value="{{ $i }}" aria-hidden="true"></i>
                            @endfor
                          </span>
                          <p>{{ $review->body }}</p>
                        </div>
                      </li>
                    @endforeach

                    @foreach($supplier->CustomerReview as $review)
                      <li class="media">
                        <div class="media-left">
                          <a href="#">
                            @if( $review->customer->avatar )
                              <img src="{{ Storage::url($review->customer->avatar) }}" class="media-object img-circle" alt="Image User">
                            @else
                              <img src="{{ asset('/img/default_user.png') }}" class="media-object img-circle" alt="Image User">
                            @endif
                          </a>
                        </div>
                        <div class="media-body">
                          <h5 class="media-heading">{{ $review->customer->name }}</h5>
                          <span>
                            @for($i = 1 ; $i <= 5 ; $i++)
                              <i class="fa {{ $i<= $review->rating ? 'fa-star' : 'fa-star-o' }} " data-value="{{ $i }}" aria-hidden="true"></i>
                            @endfor
                          </span>
                          <p>{{ $review->body }}</p>
                        </div>
                      </li>
                    @endforeach

                  </ul>
                </div>

              </div>
            </div>
          </div>


        </div>
        <div class="paginationCommon blogPagination categoryPagination">

        </div>
      </div>
    </div>
  </div>
</section>

@endsection