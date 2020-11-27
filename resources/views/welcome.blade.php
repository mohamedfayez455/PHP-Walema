
@extends('layouts.app')


@section('content')
@push('css')

  <link rel="stylesheet" type="text/css" href="{{ url('/')}}/dist/jquery-confirm/jquery-confirm.min.css">

@endpush

@push('js')

<script src="{{ url('/')}}/dist/jquery-confirm/jquery-confirm.min.js"></script>

<script type="text/javascript">

	if ( $('#keyword').val() && $('#keyword').val().length > 0 ) {
		$('.search').attr('disabled', false);
	}else {
		$('.search').attr('disabled', true);
	}

	$('#keyword').on('keyup', function(e) {

		if ( $(this).val().length > 0 ) {

			$('.search').attr('disabled', false);

		}else {

			$('.search').attr('disabled', true);
		}

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

<!-- SLIDER SECTION -->
<section class="main-slider" data-loop="true" data-autoplay="true" data-interval="7000">
  <div class="inner">

    <!-- Slide One -->
    <div class="slide slide1" style="background-image: url(img/banner/mo.jpg);">
      <div class="container">
        <div class="slide-inner1 common-inner">
          <span class="h1 from-bottom">Choose your Meal</span>
          <span class="h4 from-bottom">Listty helps to find out great things arround you</span><br>
        </div>
      </div>
    </div>

    <!-- Slide Two -->
    <div class="slide slide2" style="background-image: url(img/banner/mo.jpg);">
      <div class="container">
        <div class="slide-inner2 common-inner">
          <span class="h1 from-bottom">Choose your Meal</span>
          <span class="h4 from-bottom">Listty helps to find out great things arround you</span><br>
        </div>
      </div>
    </div>

    <!-- Slide Three -->
    <div class="slide slideResize slide4" style="background-image: url(img/banner/mo.jpg);">
      <div class="container">
        <div class="common-inner slide-inner4">
          <span class="h1 from-bottom">Choose your Meal</span>
          <span class="h4 from-bottom">Listty helps to find out great things arround you</span><br>
        </div>
      </div>
    </div>

  </div>
</section>




<!-- CATEGORY SECTION -->
<section class="clearfix bg-light">
	<div class="container">
	  <div class="row">
	      	@if( !is_supplier() )
	    <div class="col-xs-12 ">
	      <div class="bg-search-white">
	        <form class="form-inline" action="{{ route('suppliers_list') }}">
	          <div class="form-group" style="width: 43.3%;">
	            <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Enter your keywords">
	          </div>
	          <div class="form-group" style="width: 43.3%;">
              <div class="searchSelectbox">
                <select name="category_id" id="category_id" class="select-drop">
                  <option value="0">All Categories</option>
                  @foreach( App\Category::all() as $category )
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>

	          <div class="form-group">
	            <button type="submit" class="btn btn-primary search" disabled="">Search </button>
	          </div>
	        </form>
	      </div>
	    </div>
	        @endif
	  </div>
	</div>
	<div class="container">
		<div class="page-header text-center">
			<h2>Browse by Categories <small>Explore and connect with great local businesses </small></h2>
		</div>
		<div class="row">
			@foreach($categories as $category)
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="categoryItem">
						<img src="{{ $category->photo_path }}" style="width: 100%;height: 200px">
						<h2>{{ $category->name }}</h2>
						<ul class="list-unstyled">
							@foreach($category->childs()->limit(5)->get() as $child)
								<li><a>{{ $child->name }}</a></li>
							@endforeach
						</ul>
					</div>
				</div>
			@endforeach

		</div>
	</div>

</section>



<!-- THINGS SECTION -->
<section class="clearfix thingsArea">
	<div class="container">
		<div class="page-header text-center">
			<h2>This are some of most popular listings</h2>
		</div>
		<div class="row">

			@forelse($listings as $listing)

				<div class="col-md-4 col-sm-6 col-xs-12">
					<div class="thingsBox thinsSpace">
						<div class="thingsImage">
							<img src="{{ Storage::url($listing->main_photo) }}" style="width: 360px;height: 200px" alt="Image Listings">
							<div class="thingsMask">
								<ul class="list-inline rating">
				                  @for($i = 1 ; $i <= 5 ; $i++)
				                    <li><i class="fa {{ $i<= round($listing->review()) ? 'fa-star' : 'fa-star-o' }} " data-value="{{ $i }}" aria-hidden="true"></i></li>
				                  @endfor
				                  <li>{{ round($listing->review())  }}</li>
				                </ul>

								<a href=" {{ route('listings.show' , $listing->id) }} ">
									<h2>
										{{$listing->name}}
										<i class="fa fa-check-circle" aria-hidden="true">	</i>
									</h2>
								</a>
								<p>{{ $listing->city }}</p>
							</div>
						</div>
						<div class="thingsCaption ">
							<ul class="list-inline captionItem">
								<li><i class="fa fa-heart-o {{ ( user() and user()->is_user_liked_listing($listing->id) ) ? 'active':'' }}" aria-hidden="true"></i>  {{$listing->likes()->count()}} <?=($listing->likes()->count()) >= 1000 ? ($listing->likes()->count() >= 1000000 ? 'm' : 'k') : ''?></li>
								<li><a href="">{{$listing->category->name}}</a></li>
							</ul>
						</div>
					</div>
				</div>
			@empty


				<div class="col-12">
					<div class="thingsBox thinsSpace text-center alert alert-warning">
						There Is No Any Listings
					</div>
				</div>

			@endforelse
		</div>
	</div>
</section>


<!-- APP DOWNLOAD SECTION -->
<section class="clearfix appDownload">
	<div class="container">
		<div class="page-header text-center">
			<h2>Download on App Store</h2>
		</div>
		<div class="row">
			<div class="col-sm-4 col-lg-offset-4 text-center col-xs-12">
				<a href="#" class="btn btn-primary btn-transparent">
					<i class="icon-listy icon-playstore"></i><span>available on <br><strong>Google Play</strong></span>
				</a>
			</div>
		</div>
	</div>
</section>



@endsection