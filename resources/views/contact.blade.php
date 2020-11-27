@extends('layouts.app')

@section('content')

@push('js')


  <script type="text/javascript" src="{{ url('/dist/locationpicker/locationpicker.jquery.min.js') }}"></script>

  <script>

    $('#map').locationpicker({
      location:{
        latitude:'30.061291199759854',
        longitude:'31.219255447387695'
      },
      radius:500,
      markerIcon: '{{ url('/img/banner/mo.jpg') }}',

    });
  </script>

@endpush


<!-- PAGE TITLE SECTION -->
<section class="clearfix pageTitleSection bg-image" style="background-image: url(img/banner/moo.jpg);">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="pageTitle">
          <h2>Contact Us</h2>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT SECTION -->
<section class="clearfix">
	<div class="container">
		<div class="row">
			<div class="col-sm-4 col-xs-12">

        <div class="contactInfo">
					<ul class="list-unstyled list-address">
						<li>
							<i class="fa fa-map-marker" aria-hidden="true"></i>
							Shebin , Menofia<br> Egypt
						</li>
						<li>
							<i class="fa fa-phone" aria-hidden="true"></i>
							+201212479994
						</li>
						<li>
							<i class="fa fa-envelope" aria-hidden="true"></i>
							<a href="#">info@walema.com</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-sm-8 col-xs-12">
				<div class="signUpFormArea">
					<div class="priceTableTitle">
						<h2>Get inTouch</h2>
						<p>Please feel free to contact us if you have queries, require more information or have any other request.</p>
					</div>
					<div class="signUpForm">
						<form action="{{ route('contact') }}" method="POST">
              {{ csrf_field() }}
							<div class="formSection">
								<div class="row">
									<div class="form-group col-sm-12 col-xs-12">
                                        <label for="subject" class="control-label">Subject*</label>
                                        <input type="text" value="{{old('subject')}}" class="form-control" name="subject">
									</div>

									<div class="form-group col-xs-12">
										<label for="name" class="control-label">Your Name*</label>
										<input type="text" value="{{old('name')}}" class="form-control" name="name">
									</div>
									<div class="form-group col-xs-12">
										<label for="email" class="control-label">Email Address*</label>
										<input type="email" value="{{old('email')}}" class="form-control" name="email">
									</div>
									<div class="form-group col-xs-12">
										<label for="content" class="control-label">Content*</label>
										<textarea class="form-control" name="content" rows="3">{{old('content')}}</textarea>
									</div>
									<div class="form-group col-xs-12 mb0">
										<button type="submit" class="btn btn-primary">Send Now</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

  </div>

  <!-- LOGIN  MODAL -->
  <div id="loginModal" tabindex="-1" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Log In to your Account</h4>
        </div>
        <div class="modal-body">
          <form class="loginForm">
            <div class="form-group">
              <i class="fa fa-envelope" aria-hidden="true"></i>
              <input type="email" class="form-control" id="email" placeholder="Email">
            </div>
            <div class="form-group">
              <i class="fa fa-lock" aria-hidden="true"></i>
              <input type="password" class="form-control" id="pwd" placeholder="Password">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-block">Log In</button>
            </div>
            <div class="checkbox">
              <label><input type="checkbox"> Remember me</label>
              <a href="#" class="pull-right link">Fogot Password?</a>
            </div>

          </form>
        </div>
        <div class="modal-footer">
          <p>Don’t have an Account? <a href="#" class="link">Sign up</a></p>
        </div>
      </div>
    </div>
  </div>

@endsection()
