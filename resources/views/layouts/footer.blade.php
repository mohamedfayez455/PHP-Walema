 <!-- FOOTER -->
    @php
      $footer_logo = url('/img/background/bg-footer.jpg');
    @endphp
    <footer style="background-image: url('{{ $footer_logo }}')">
      <!-- FOOTER INFO -->
      <div class="clearfix footerInfo">
        <div class="container">
          <div class="row">
            <div class="col-sm-7 col-xs-12">
              <div class="footerText">
                <a href="{{ url('/') }}" class="footerLogo">
                  <img style="width: 100px;height: 100px;margin-top: -30px" src="{{ Storage::url(setting()->icon) }}" class="img-responsive">
                </a>

                <ul class="list-styled list-contact">
                  <li><i class="fa fa-phone" aria-hidden="true"></i>+201212479994</li>
                  <li><i class="fa fa-envelope" aria-hidden="true"></i><a href="#">info@walema.com</a></li>
                </ul>
              </div>
            </div>
            <div class="col-sm-3 col-xs-12">
              <div class="footerInfoTitle">
                <h4>Links</h4>
              </div>
              <div class="useLink">
                <ul class="list-unstyled">
                  @if( is_authenticated()  )
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                  @else

                    <li><a href="{{ route('login') }}">Login</a></li>
                    <li><a href="{{ route('suppliers.register') }}">Create Supplier Account</a></li>
                    <li><a href="{{ route('customers.register') }}">Create Customer Account</a></li>

                  @endif
                </ul>
              </div>
            </div>
            <div class="col-sm-2 col-xs-12">
              <div class="footerInfoTitle">
                <h4>Company</h4>
              </div>
              <div class="useLink">
                <ul class="list-unstyled">
                  <li><a href="{{ route('contact') }}">Contact Us</a></li>
                  <li><a href="{{ route('about_us') }}">About us</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>

      @include('subscribe')

      <!-- COPY RIGHT -->
      <div class="clearfix copyRight">
        <div class="container">
          <div class="row">
            <div class="col-xs-12">
              <div class="copyRightWrapper">
                <div class="row">
                  <div class="col-sm-5 col-sm-push-7 col-xs-12">
                  </div>
                  <div class="col-sm-7 col-sm-pull-5 col-xs-12">
                    <div class="copyRightText">
                      <strong>©2020 All Rights Reserved FCI. Developed BY Mego</strong>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </footer>
  </div>


<script type="text/javascript">

  var baseURI = window.location.origin;

  if (baseURI == 'http://167.172.208.67') {
    baseURI += '/lara-walema/public/';
    chatURL = 'http://167.172.208.67:3000';
  }else {
    baseURI += '/';
    chatURL = 'http://127.0.0.1:3000';
  }


</script>

<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('plugins/jquery/jquery-migrate.js')}}"></script>
    <script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{asset('plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('plugins/smoothscroll/SmoothScroll.min.js')}}"></script>
    <script src="{{asset('plugins/waypoints/waypoints.min.js')}}"></script>
    <script src="{{asset('plugins/counter-up/jquery.counterup.min.js')}}"></script>
    <script src="{{asset('plugins/datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('plugins/selectbox/jquery.selectbox-0.1.3.min.js')}}"></script>
    <script src="{{asset('plugins/owl-carousel/owl.carousel.min.js')}}"></script>
    <script src="{{asset('plugins/slick/slick.min.js')}}"></script>
    <script src="{{asset('plugins/isotope/isotope.min.js')}}"></script>
    <script src="{{asset('plugins/fancybox/jquery.fancybox.min.js')}}"></script>
    <script src="{{asset('plugins/isotope/isotope-triger.min.js')}}"></script>
    <script src="{{asset('plugins/rateyo/jquery.rateyo.min.js')}}"></script>

        <!--
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDU79W1lu5f6PIiuMqNfT1C6M0e_lq1ECY"></script>
        !-->
     <script type="text/javascript" src='https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyBwxuW2cdXbL38w9dcPOXfGLmi1J7AVVB8'></script>


    <script src="{{asset('js/map.js')}}"></script>

    <script src="{{asset('js/custom.js')}}"></script>


  @stack('js')


  <script>

    $('.loginLink').on('click', function(e) {

        $(this).parent().find('.dropdown-menu').css({
          position: 'absolute',
          top: '78px',
          left: '-232px',
        });

    });

    $('.nav-links').mouseenter(function(event) {

      $(this).css({
          color: '#222',
        });

        var vm = $(this);

        $('.nav-links').each(function(index, el) {

          if (vm.attr('id') != $(this).attr('id')  ) {

            $(this).css({
              color: '#fff',
            });
          };

        });


    });

    $('.nav-links').mouseleave(function(event) {

            $(this).each(function(index, el) {
              $(this).css({
                color: '#fff',
              });
          });


    });


  </script>





  <?php if (is_authenticated()) {?>

  <script src="{{ url('/')}}/dist/socket.io-client/socket.io.js"></script>
  <script src="{{ url('/')}}/js/socket.io.js"></script>

  <script type="text/javascript">

    var user_id = '{{ user()->id }}';
    var name = '{{  is_supplier() ? supplier()->name : customer()->name }}';
    var user_image="{{ user()->avatar }}";
    var typingurl= '{{ url('img/typing.gif') }}';
    var message = '{{ url('/chat/message') }}';
    var token = '{{ csrf_token() }}';

    var my_friends = [];

   $('.messageCommon').each(function(index, el) {
    var user_id = $(this).attr('user_id');
    my_friends.push(user_id);
   });

   var active_suppliers = [];
   var active_customers = [];

   var socket = io.connect(chatURL , {

    query: 'user_id=' + user_id + '&name=' + name + '&user_image=' + user_image +'&my_friends=' + my_friends+'&role='+'user'

   });

       $('.likePart').on('click', function(e) {

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


  </script>

<?php }?>

  </body>


  </html>
