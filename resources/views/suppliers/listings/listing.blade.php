@extends('layouts.app')

@section('content')


@push('js')


	<script type="text/javascript" src="{{ url('/dist/locationpicker/locationpicker.jquery.min.js') }}"></script>

	<script>


	  $('.liking').on('click', function(e) {

	    var LikedUrl = '{{ url('listings/like/'. $listing->id ) }}';
	    var UnLikedUrl = '{{ url('listings/unlike/'. $listing->id) }}';
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
	    	$('.number').html(response.likes);
	    })
	    .fail(function() {
	      console.log("error");
	    });


	  });

	  var role = '{{ user()->role }}';

	  $('.user_rat li').on('click' , function(e) {

	  	if ( $(this).parent().hasClass(role) ) {

		  	var id = e.currentTarget.parentNode.id ;
		  	var vm = this;
		  	var vote = $(this).children('i').data('value');

		    $.ajax({
		      url: '{{ url('/listings/rating')}}/' + id,
		      type: 'GET',
		      dataType: 'json',
		      data:{vote:vote}
		    })
		    .done(function(response) {

		    	if ( response.status == true ) {

			    	var childrens = $(vm).parent().children();


			    	for( var i =0 ; i< 5 ; i++ ){

			    		if (i< vote) {

			    			$(childrens[i]).children().removeClass('fa-star-o');
			    			$(childrens[i]).children().addClass('fa-star');

			    		}else {

			    			$(childrens[i]).children().addClass('fa-star-o');
			    			$(childrens[i]).children().removeClass('fa-star');

			    		}

			    	}

		    	}

		    }).fail(function() {
		      console.log("error");
		    });


	  	};

	  });



	  $('.rating-review li').on('click', function(e) {

	  	var vote = $(this).children('i').data('value');
	  	$('input[name="rating"]').val(vote);

	  	var childrens = $(this).parent().children();

	  	for( var i =0 ; i< 5 ; i++ ){

		    if (i< vote) {

		    	$(childrens[i]).children().removeClass('fa-star-o');
		    	$(childrens[i]).children().addClass('fa-star');

		    }else {

		    	$(childrens[i]).children().addClass('fa-star-o');
		    	$(childrens[i]).children().removeClass('fa-star');

		    }

		}


	  });


	</script>



@endpush

<!-- LISTINGS DETAILS TITLE SECTION -->
<section class="clearfix paddingAdjustBottom">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<div class="listingTitleArea">
					<h2>{{ $listing->name }}</h2>
					<div class="listingReview">
						<ul class="list-inline rating">

							@for($i = 1 ; $i <= 5 ; $i++)
								<li><i class="fa {{ $i<= round($listing->review()) ? 'fa-star' : 'fa-star-o' }} " data-value="{{ $i }}" aria-hidden="true"></i></li>
							@endfor
						</ul>
						<span>( {{ round($listing->review() ) }} Reviews )</span>
						<ul class="list-inline captionItem text-center">
							<li class="liking text-center">
								<i class="fa fa-heart-o {{ ( user()->is_user_liked_listing($listing->id) ) ? 'active':'' }}" aria-hidden="true"></i>
								<span style="margin-right: 5px;" class="number">{{ count($listing->likes) }}</span>
							</li>
						</ul>
						<a href="#review" class="btn btn-primary">Write a review</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- LISTINGS DETAILS IMAGE SECTION -->
<section class="clearfix paddingAdjustTopBottom text-center" style="border-top: 1px solid #e5e5e5;border-bottom: 1px solid #e5e5e5;margin-bottom: 15px;padding-bottom: 1px;">
	<ul class="list-inline listingImage text-center">

		@forelse($listing->files as $file)

			<li class="text-center"><img src="{{ Storage::url($file->full_path) }}" style="width: 400px;height: 264px;" alt="Image Listing" class="img-responsive"></li>

		@empty

		@endforelse
	</ul>
</section>

<!-- LISTINGS DETAILS INFO SECTION -->
<section class="clearfix paddingAdjustTop">
	<div class="container">
		<div class="row">
			<div class="col-sm-12 col-xs-12">
				<div class="listDetailsInfo">
					<div class="detailsInfoBox">
						<h3>About Listing</h3>
						<p>{{ $listing->description }}</p>
					</div>

					<div class="detailsInfoBox">
						<h3>Reviews ({{ count($listing->CustomerReview) + count($listing->SupplierReview)}})</h3>

						@foreach($listing->CustomerReview as $review)

						<div class="media media-comment">
							<div class="media-left">

							@if( $review->customer->avatar )
								<img src="{{ Storage::url($review->customer->avatar) }}" class="media-object img-circle" alt="Image User">
							@else
								<img src="{{ asset('/img/default_user.png') }}" class="media-object img-circle" alt="Image User">
							@endif

							</div>
							<div class="media-body">
								<h4 class="media-heading">{{ $review->customer->name }}</h4>
								<ul class="list-inline rating customer user_rat" id="{{ $review->id}}">

									@for($i = 1 ; $i <= 5 ; $i++)
										<li style="cursor: pointer"><i class="fa {{ $i<= $review->rating ? 'fa-star' : 'fa-star-o' }} " data-value="{{ $i }}" aria-hidden="true"></i></li>
									@endfor
								</ul>
								<p>{{ $review->body }}</p>
							</div>
						</div>
						@endforeach

						@foreach($listing->SupplierReview as $review)

						<div class="media media-comment">
							<div class="media-left">
							@if( $review->supplier->avatar )
								<img src="{{ Storage::url($review->supplier->avatar) }}" class="media-object img-circle" alt="Image User">
							@else
								<img src="{{ asset('/img/default_supplier.jpg') }}" class="media-object img-circle" alt="Image User">
							@endif
							</div>
							<div class="media-body">
								<h4 class="media-heading">{{ $review->supplier->name }}</h4>
								<ul class="list-inline rating supplier user_rat" id="{{ $review->id}}">
									@for($i = 1 ; $i <= 5 ; $i++)
										<li style="cursor: pointer"><i class="fa {{ $i<= $review->rating ? 'fa-star' : 'fa-star-o' }} " data-value="{{ $i }}" aria-hidden="true"></i></li>
									@endfor
								</ul>
								<p>{{ $review->body }}</p>
							</div>
						</div>
						@endforeach


					</div>
					<div id="review" class="detailsInfoBox">
						<h3>Write A Review </h3>
						<div class="listingReview">
							<span>( {{ round($listing->review() ) }} Reviews )</span>
							<ul class="list-inline rating rating-review">
								@for( $i = 1 ; $i <= 5 ; $i++ )
									<li style="cursor: pointer">
										<i class="fa fa-star" data-value="{{ $i }}" aria-hidden="true"></i>
									</li>
								@endfor
							</ul>
						</div>

							<form action="{{ is_customer() ? route('contracor_review.store')  : route('supplier_review.store') }}" method="POST">

							{{ csrf_field() }}
							<div class="formSection formSpace">
								<div class="form-group">
									<textarea class="form-control" rows="3" placeholder="Body" name="body"></textarea>
								</div>
								<input type="hidden" name="listing_id" value="{{ $listing->id }}">
								<input type="hidden" name="rating" value="5">

								<div class="form-group mb0">
									<button type="submit" class="btn btn-primary">Send Review</button>
								</div>
							</div>
						</form>

					</div>
				</div>

			</div>
		</div>
	</div>
</section>

@endsection