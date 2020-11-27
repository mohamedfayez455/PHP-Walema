@extends('layouts.app')

@section('content')
<!-- Dashboard breadcrumb section -->
<section class="clearfix bg-dark listyPage">
<div class="section dashboard-breadcrumb-section bg-dark">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h2>Review</h2>
        <ol class="breadcrumb">
          <li><a href="/">Home</a></li>
          <li><a href="{{route('home')}}">Dashboard</a></li>
          <li class="active">Review</li>
        </ol>
      </div>
    </div>
  </div>
</div>


<!-- DASHBOARD REVIEWS SECTION -->
<section class="clearfix bg-dark dashboard-review-section">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-lg-6">
        <div class="dashboard-list-box">
          <div class="list-sort">
            <div class="sort-left">Visitor Reviews</div>
            <div class="sort-right sort-select">
              <select name="guiest_id2" id="guiest_id2" class="select-drop">
                <option value="0">All Listings</option>
                <option value="1">Tom's Restaurant</option>
                <option value="2">Sticky Band</option>
                <option value="3">Hotel Govendor</option>
                <option value="4">Burger House</option>
                <option value="5">Airport</option>
                <option value="6">Think Coffee</option>
              </select>
            </div>
          </div>
          <div class="single-list">
            <div class="media comments-media">
              <div class="media-left">
                <a href="#">
                  <img src="{{asset('img/dashboard/recent-user-1.jpg')}}" alt="User Image">
                </a>
              </div>
              <div class="media-body">
                <h4 class="media-heading">Kathy Brown <a href="#">on Burger House</a> <div class="visitor star"></div></h4>
                <div class="date">Feb 2018</div>
                <p>Morbi velit eros, sagittis in facilisis non, rhoncus et erat. Nam posuere tristique sem, eu ultricies tortor imperdiet vitae. Curabitur lacinia neque non metus</p>
                <div class="content-img">
                  <img src="{{asset('img/dashboard/burger-img-01.png')}}" alt="Image">
                  <img src="{{asset('img/dashboard/burger-img-02.jpg')}}" alt="Image">
                </div>
                <a href="#" class="btn btn-primary"><i class="fa fa-reply" aria-hidden="true"></i>Reply to this review</a>
              </div>
            </div>
          </div>
          <div class="single-list">
            <div class="media comments-media">
              <div class="media-left">
                <a href="#">
                  <img src="{{asset('img/dashboard/recent-user-2.jpg')}}" alt="User Image">
                </a>
              </div>
              <div class="media-body">
                <h4 class="media-heading">Macgaiver <a href="#">on coffe House</a> <div class="visitor star"></div></h4>
                <div class="date">Jan 2018</div>
                <p>Morbi velit eros, sagittis in facilisis non, rhoncus et erat. Nam posuere tristique sem, eu ultricies tortor imperdiet vitae. Curabitur lacinia neque non metus</p>
                <div class="content-img">
                  <img src="{{asset('img/dashboard/coffe-img-01.jpg')}}" alt="Image">
                </div>
                <a href="#" class="btn btn-primary "><i class="fa fa-reply" aria-hidden="true"></i>Reply to this review</a>
              </div>
            </div>
          </div>
          <div class="single-list">
            <div class="media comments-media">
              <div class="media-left">
                <a href="#">
                  <img src="{{asset('img/dashboard/recent-user-3.jpg')}}" alt="User Image">
                </a>
              </div>
              <div class="media-body">
                <h4 class="media-heading">John Doe <a href="#">on Water Grill</a> <div class="visitor star"></div></h4>
                <div class="date">Dec 2018</div>
                <p>Morbi velit eros, sagittis in facilisis non, rhoncus et erat. Nam posuere tristique sem, eu ultricies tortor imperdiet vitae. Curabitur lacinia neque non metus</p>
                <a href="#" class="btn btn-primary"><i class="fa fa-reply" aria-hidden="true"></i>Reply to this review</a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-lg-6">
        <div class="dashboard-list-box">
          <div class="list-sort">
            <div class="sort-left">Your Reviews</div>
          </div>
          <div class="single-list">
            <div class="media comments-media">
              <div class="media-left">
                <a href="#">
                  <img src="{{asset('img/dashboard/recent-user-4.jpg')}}" alt="User Image">
                </a>
              </div>
              <div class="media-body">
                <h4 class="media-heading">Tom Wilson <a href="#">on Think Coffee</a> <div class="user star"></div></h4>
                <div class="date">Feb 2018</div>
                <p>Morbi velit eros, sagittis in facilisis non, rhoncus et erat. Nam posuere tristique sem, eu ultricies tortor imperdiet vitae. Curabitur lacinia neque non metus</p>
                <a href="#" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i>edit</a>
              </div>
            </div>
          </div>
          <div class="single-list">
            <div class="media comments-media">
              <div class="media-left">
                <a href="#">
                  <img src="{{asset('img/dashboard/recent-user-4.jpg')}}" alt="User Image">
                </a>
              </div>
              <div class="media-body">
                <h4 class="media-heading">Tom Wilson <a href="#">on Burger House</a> <div class="user star"></div></h4>
                <div class="date">Feb 2018</div>
                <p>Morbi velit eros, sagittis in facilisis non, rhoncus et erat. Nam posuere tristique sem, eu ultricies tortor imperdiet vitae. Curabitur lacinia neque non metus</p>
                <a href="#" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i>edit</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="paginationCommon blogPagination text-center">
      <nav aria-label="Page navigation">
        <ul class="pagination">
          <li>
            <a href="#" aria-label="Previous">
              <span aria-hidden="true"><i class="fa fa-angle-left" aria-hidden="true"></i></span>
            </a>
          </li>
          <li class="active"><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">4</a></li>
          <li><a href="#">5</a></li>
          <li>
            <a href="#" aria-label="Next">
              <span aria-hidden="true"><i class="fa fa-angle-right" aria-hidden="true"></i></span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</section>

</div>

  </div>
@endsection()
