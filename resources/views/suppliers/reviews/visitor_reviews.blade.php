



      @foreach( $visitor_reviews as $visitor_reviews_of_listing)

        @if ( is_array($visitor_reviews_of_listing) )

          @foreach( $visitor_reviews_of_listing as $review)

            <div class="single-list">
                <div class="media comments-media">
                  <div class="media-left">
                    <a href="#">

                      @if ($review->customer->avatar)
                      <img src="{{Storage::url( $review->customer->avatar )}}" alt="User Image">
                      @else
                        <img src="{{asset('img/dashboard/recent-user-1.jpg')}}" alt="User Image">
                      @endif
                    </a>
                  </div>
                  <div class="media-body">
                    <h4 class="media-heading">{{$review->customer->name}}
                    <div class="visitor star"></div></h4>
                    <div class="date">{{$review->created_at->diffForHumans()}}</div>
                    <p>{{ $review->body}}</p>


                    <a href="#" class="btn btn-primary reply_to" data-name="${review.customer.name}"  id="${review.id}"><i class="fa fa-reply" aria-hidden="true"></i>Reply to this review</a>
                    <span class="pull-right replies_num_{{$review->id}} badge">{{$review->replies->length}}</span>


                  </div>
                </div>
            </div>

          @endforeach

        @else


          <div class="single-list">
                <div class="media comments-media">
                  <div class="media-left">
                    <a href="#">
                      @if ($visitor_reviews_of_listing->customer->avatar)
                      <img src="{{Storage::url( $review->customer->avatar )}}" alt="User Image">
                      @else
                        <img src="{{asset('img/default_user.png')}}" alt="User Image">
                      @endif
                    </a>
                  </div>
                  <div class="media-body">
                    <h4 class="media-heading">
                      {{ $visitor_reviews_of_listing->customer->name }}
                    <div class="visitor star">


                      <ul class="list-inline rating">

                      @for ($i = 0; $i < 5; $i++)

                        @if ( $i< $visitor_reviews_of_listing->rating )
                          <li><i class="fa fa-star" data-value="{{ $i }}" aria-hidden="true"></i></li>
                        @else
                          <li><i class="fa fa-star-o" data-value="{{ $i }}" aria-hidden="true"></i></li>
                        @endif
                      @endfor

                      </ul>

                    </div>
                    </h4>
                    <div class="date">
                      {{ $visitor_reviews_of_listing->created_at->diffForHumans() }}</div>
                    <p>
                      {{ $visitor_reviews_of_listing->body }}
                    </p>
                    <a href="#" class="btn btn-primary reply_to" data-name="{{$visitor_reviews_of_listing->customer->name}}"  id="{{$visitor_reviews_of_listing->id}}"><i class="fa fa-reply" aria-hidden="true"></i>Reply to this review</a>
                    <span class="pull-right replies_num_{{$visitor_reviews_of_listing->id}} badge">{{$visitor_reviews_of_listing->replies()->count()}}</span>


                  </div>
                </div>
              </div>
    @endif
@endforeach
