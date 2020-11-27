@extends('layouts.app')

@section('content')


@push('css')

  <link rel="stylesheet" type="text/css" href="{{ url('/')}}/dist/jquery-confirm/jquery-confirm.min.css">

  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/css/chat.css">

@endpush


@push('js')

    <script src="{{ url('/')}}/dist/jquery-confirm/jquery-confirm.min.js"></script>
    <script src="{{asset('plugins/map/js/infobox_packed.js')}}"></script>
    <script src="{{asset('plugins/map/js/rich-marker.js')}}"></script>
    <script src="{{asset('js/searchmap.js')}}"></script>
    <script src="{{asset('plugins/flot/jquery.flot.js')}}"></script>
    <script src="{{asset('plugins/flot/jquery.flot.time.js')}}"></script>
    <script src="{{asset('js/chart.js')}}"></script>

    <script type="text/javascript">


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
<section class="clearfix bg-dark listyPage">
<div class="section dashboard-breadcrumb-section bg-dark">
<div class="container">
<div class="row">
  <div class="col-xs-12">


    <h2>Dashboard</h2>
    <ol class="breadcrumb">
      <li><a href="/">Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </div>
</div>
</div>
</div>
<!-- DASHBOARD SECTION -->
<section class="clearfix bg-dark equalHeight dashboardSection">
<div class="container">
<div class="row">
  <div class="col-sm-4 col-xs-12">
    <div class="panel panel-default panel-card">
      <div class="panel-heading">
        Listings <span class="label label-primary">Daily</span>
      </div>
      <div class="panel-body">
        <h2>{{ count( customer()->listings ) }}</h2>
      </div>
    </div>
  </div>
  <div class="col-sm-4 col-xs-12">
    <div class="panel panel-default panel-card">
      <div class="panel-heading">
        Suppliers <span class="label label-primary">Daily</span>
      </div>
      <div class="panel-body">
        <h2> {{ count( customer()->suppliers ) }} </h2>
      </div>
    </div>
  </div>
  <div class="col-sm-4 col-xs-12">
    <div class="panel panel-default panel-card">
      <div class="panel-heading">
        Reviews <span class="label label-primary">Daily</span>
      </div>
      <div class="panel-body">
        <h2>{{ count( customer()->reviews ) }}</h2>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-sm-4 col-xs-12">
    <div class="panel panel-default panel-card">
      <div class="panel-heading">
        Popular Listings
      </div>
      <div class="panel-body plr">
        <ul class="list-unstyled panel-list">
          @forelse( popular_listings() as $listing)
          <li>
            <div class="listWrapper">
              <div class="listName">
                <h3>
                  <a href="{{ route('listings.show' , $listing->id) }}"> {{ $listing->name }} </a>
                  <small>{{ $listing->city }}</small></h3>
              </div>
              <div class="listResult">
                <ul class="list-inline rating">
                  @for($i = 1 ; $i <= 5 ; $i++)
                    <li><i class="fa {{ $i<= round($listing->review()) ? 'fa-star' : 'fa-star-o' }} " data-value="{{ $i }}" aria-hidden="true"></i></li>
                  @endfor
                </ul>
                <span class="likeCount likePart" id="{{ $listing->id}}">
                      <i class="fa fa-heart-o {{ ( user()->is_user_liked_listing($listing->id) ) ? 'active':'' }}" aria-hidden="true"></i>
                      <span style="margin-right: 5px;" class="number{{$listing->id}}">{{ count($listing->likes) }}</span>
                </span>
              </div>
            </div>
          </li>
          @empty
          <li class="text-center text-info">There is No Any Listing</li>
        @endforelse
        </ul>
      </div>
    </div>
  </div>
  <div class="col-sm-4 col-xs-12">
    <div class="panel panel-default panel-card">
      <div class="panel-heading" id="categories">
        Popular Categories
      </div>
      <div class="panel-body plr">
        <ul class="list-styled panel-list list-padding">
          @forelse( popular_categories() as $category)
          <li class="listWrapper">
            <span class="itmeName">
              <i class="fa fa-list"></i>
              {{ $category->name }}
            </span>
          </li>
          @empty
          <li class="text-center text-info">There is No Any Category</li>
        @endforelse
        </ul>
      </div>
    </div>
  </div>
  <div class="col-sm-4 col-xs-12">
    <div class="panel panel-default panel-card">
      <div class="panel-heading">
        Recent Users
      </div>
      <div class="panel-body plr">
        <ul class="list-styled panel-list list-padding-sm">
          @forelse( recent_user() as $user)
          <li  class="listWrapper">
            <span class="recentUserInfo">
              @if( $user->avatar )
                <img class="user_img" src="{{$user->avatar}}" style="border-radius: 50%" width="70px" height="70px" class="user-image" alt="User Image">
              @else
                  <img class="user_img" src="{{ asset('/img/default_supplier.jpg') }}" width="70px" height="70px" class="user-image" alt="User Image">
              @endif

              <a style="font-size:11px;font-weight: bold;" href="{{ route('supplier.profile' , $user->supplier->id) }}">
                  {{ $user->supplier->name }}
                </a>

            </span>
            <span class="userTime">{{ $user->last_message_info(user()->id) ? $user->last_message_info(user()->id)->created_at->diffForHumans() : '' }}
            </span>
          </li>
          @empty
          <li class="text-center text-info">There is No Any User</li>
        @endforelse
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-xs-12">
    <div class="panel panel-default panel-card">
      <div class="panel-heading" id="message">
        Messages <a href="#" class="btn label label-primary">Send Message</a>
      </div>
      <div class="panel-body panel-message">
        <ul class="list-unstyled panel-list">

          @forelse( customer()->friends_collection() as $user )

          @php
            $user = $user->supplierUser;
            $last_message_info = $user->last_message_info(user()->id);
          @endphp
          @if($last_message_info)
          <li style="cursor: pointer" id="side-user-box" user_role="{{ $user->role }}" user_image="{{ $user->avatar }}" class="messageCommon recentMessage listWrapper" user_id='{{ $user->id }}' name='{{ $user->firstname . ' ' . $user->lastname }}'>
            <span class="messageInfo">

              <h5 class="name">{{ $user->firstname . ' ' . $user->lastname }}, <small> <span class="dayTime">{{ $last_message_info->created_at  }}</span></small></h5>
              <p class="last-message"> {{ $last_message_info->content }}</p>
            </span>
            <span class="messageTime">{{ $last_message_info->created_at->diffForHumans() }}</span>
          </li>
          @endif
          @empty
          <li>You Never Connect With Any Supplier </li>

          @endforelse
        </ul>
      </div>
    </div>
  </div>
</div>

<div class="row" id="complaints">
  <div class="col-xs-12">
    <div class="panel panel-default panel-card">
      <div class="panel-heading" id="message">
        Complaints <a href="#" class="btn label label-primary">Send Complaints</a>
      </div>
      <div class="panel-body panel-message">
        <ul class="list-unstyled panel-list">

          @forelse( customer()->complaints() as $complaint )

          <li>
            <span class="messageInfo">
              <h5 class="name">
                <a href="{{ route('supplier.profile' , $complaint->reciever->supplier->id) }}">
                  {{ $complaint->reciever->firstname . ' ' . $complaint->reciever->lastname }}
                </a>
              </h5>

              <p class="last-message"> {{ $complaint->message }}</p>
            </span>
            <span class="messageTime">{{ $complaint->created_at->diffForHumans() }}</span>
          </li>
          @empty
          <li>You Never Send Complaint To Any Supplier </li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>
</div>





<div class="row" id="complaints">
  <div class="col-xs-12">
    <div class="panel panel-default panel-card">
      <div class="panel-heading" id="message">
        Enquiries <a href="#" class="btn label label-primary">Enquiries</a>
      </div>
      <div class="panel-body panel-message">
        <ul class="list-unstyled panel-list">

          @forelse( customer()->enquries() as $enqury)

          <li>
            <span class="messageInfo">
              <h5 class="name">
                <a href="{{ route('supplier.profile' , $enqury->reciever->supplier->id) }}">
                  {{ $enqury->reciever->firstname . ' ' . $enqury->reciever->lastname }}
                </a>
              </h5>

              <p class="last-message"> {{ $enqury->message }}</p>
            </span>
            <span class="messageTime">{{ $enqury->created_at->diffForHumans() }}</span>
          </li>
          @empty
          <li>You Never Recieved Any Enquiry </li>
          @endforelse
        </ul>
      </div>
    </div>
  </div>
</div>

</div>
</section>
</div>


  </div>
@endsection
