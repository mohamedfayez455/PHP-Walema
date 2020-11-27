@extends('layouts.app')

@section('content')

<!-- SLIDER SECTION -->
<section class="main-slider" data-loop="true" data-autoplay="true" data-interval="7000">
  <div class="inner">

    <!-- Slide One -->
    <div class="slide slide1" style="background-image: url({{asset('img/banner/slider-1.jpg')}});">
      <div class="container">
        <div class="slide-inner1 common-inner">
          <span class="h1 from-bottom">Choose your vehicles</span>
          <span class="h4 from-bottom">Listty helps to find out great things arround you</span><br>
        </div>
      </div>
    </div>

    <!-- Slide Two -->
    <div class="slide slide2" style="background-image: url({{asset('img/banner/slider-1.jpg')}});">
      <div class="container">
        <div class="slide-inner2 common-inner">
          <span class="h1 from-bottom">Choose your vehicles</span>
          <span class="h4 from-bottom">Listty helps to find out great things arround you</span><br>
        </div>
      </div>
    </div>

    <!-- Slide Three -->
    <div class="slide slideResize slide4" style="background-image: url({{asset('img/banner/slider-1.jpg')}});">
      <div class="container">
        <div class="common-inner slide-inner4">
          <span class="h1 from-bottom">Choose your vehicles</span>
          <span class="h4 from-bottom">Listty helps to find out great things arround you</span><br>
        </div>
      </div>
    </div>

  </div>
</section>




<!-- CATEGORY SECTION -->
<section class="clearfix bg-light">

<!-- CATEGORY GRID SECTION -->
<section class="clerfix categoryGrid">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<div class="resultBar">
					<h2>We found <span class="badge">  {{ $number_of_customers }} </span> Results for you</h2>

				</div>
				<div class="row">

					@foreach($customers as $customer)

					<div class="col-sm-4 col-xs-12">
						<div class="thingsBox thinsSpace">
							<div class="thingsImage">
								@if($customer->avatar)
									<img src="{{ $customer->avatar }}" alt="Image things">
								@else
									<img src="{{asset('img/default_user.png')}}" alt="Image things">
								@endif
								<div class="thingsMask">
									<ul class="list-inline rating">
										<li><i class="fa fa-star" aria-hidden="true"></i></li>
										<li><i class="fa fa-star" aria-hidden="true"></i></li>
										<li><i class="fa fa-star" aria-hidden="true"></i></li>
										<li><i class="fa fa-star" aria-hidden="true"></i></li>
										<li><i class="fa fa-star-o" aria-hidden="true"></i></li>
									</ul>
									<a href="{{ route('customer.profile' , $customer->id) }}">
										<h2>{{ $customer->name }}
											<i class="fa fa-check-circle" aria-hidden="true"></i>
										</h2>
									</a>

								</div>
							</div>
							<div class="thingsCaption ">
								<ul class="list-inline captionItem">
									<li>
										<a href="c{{ route('customer.profile' , $customer->id) }}" class="badge" style="padding: 5px;color: white">
											{{ $customer->name }}
										</a>
									</li>
								</ul>
							</div>
						</div>
					</div>

					@endforeach


				</div>
				<div class="paginationCommon blogPagination categoryPagination">
					<nav aria-label="Page navigation">
						<ul class="pagination">

							{{ $customers->links() }}

						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</section>

</div>
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
