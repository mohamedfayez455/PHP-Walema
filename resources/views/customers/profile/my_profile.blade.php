
@extends('layouts.app')

@section('content')
@push('css')
  <link rel="stylesheet" type="text/css" href="{{ url('/') }}/css/chat.css">

  <link rel="stylesheet" type="text/css" href="{{ url('/')}}/dist/jquery-confirm/jquery-confirm.min.css">

@endpush


@push('js')

    <script src="{{ url('/')}}/dist/jquery-confirm/jquery-confirm.min.js"></script>
  <script>

    $('.liking').on('click', function(e) {

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
            @if($customer->avatar)
            <img src="{{ $customer->avatar }}" alt="User Image" style="width: 220px;height: 220px;">
            @else
            <img src="{{ asset('/img/default_user.png') }}" alt="User Image" style="width: 220px;height: 220px;">
            @endif
          </div>
        </div>
        <div class="col-xs-12 col-sm-8">
          <div class="user-profile-content">
            <h3 class="user-name">{{ $customer->name }}</h3>

            <ul class="user-contact-details">
              <li><i class="fa fa-envelope" aria-hidden="true"></i><a href="#">{{ $customer->user->email }}</a></li>
              @foreach($customer->additional_data as $name => $value )

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


            @if( supplier() )

            <div>
              <div user_id='{{ $customer->user->id }}' user_role="customer" name='{{ $customer->name }}' id="side-user-box" user_image="{{ $customer->avatar }}" style="padding: 10px;color: #2196f3;cursor: pointer;background-color: #fff;border: 1px solid;" class="verified-user messageCommon"><i class="fa fa-envelope" aria-hidden="true"></i> Message
              </div>
            </div>

            @endif

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection