@extends('layouts.app')

@section('content')


@push('css')
  <link rel="stylesheet" type="text/css" href="{{ url('/dist/loader/app.min.css') }}">

  <link rel="stylesheet" type="text/css" href="{{ url('/')}}/dist/jquery-confirm/jquery-confirm.min.css">

@endpush

@push('js')

<script type="text/javascript" src="{{ url('/dist/loader/app.min.js') }}" ></script>
<script src="{{ url('/')}}/dist/jquery-confirm/jquery-confirm.min.js"></script>

<script>

  $(document).ready(function() {


  if ( $('#keyword').val().length > 0 ) {
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


    var search_key = 'search';

    $('.search').on('click', function(e) {

      e.preventDefault();

      var keyword = $('#keyword').val();
      var category_id = $('#category_id').val();
      var type_id = $('#type_id').val();
      var url = '{{ url('/suppliers') }}';
      getSuppliers(url, keyword,category_id,type_id);


    });


    function advanced_search(e) {

      var categories_checked = $('.categoryList > li input[type="checkbox"]').filter(':checked');
      var categories_id = [];

      for (var i = 0; i < categories_checked.length; i++) {
         categories_id[i] = categories_checked[i].value;
      };

      var subcategories_checked = $('.subcategoryList > li input[type="checkbox"]').filter(':checked');
      var subcategories_id = [];

      for (var i = 0; i < subcategories_checked.length; i++) {
          subcategories_id[i] = subcategories_checked[i].value;
      };

      var types_checked = $('.typeList > li input[type="checkbox"]').filter(':checked');
      var types_id = [];

      for (var i = 0; i < types_checked.length; i++) {
         types_id[i] = types_checked[i].value;
      };

      var url = '{{ url('/suppliers') }}';

      AdvancedGetSuppliers(url,categories_id, subcategories_id ,types_id);


    };

    $('.categoryList > li input[type="checkbox"]').on('change', advanced_search );
    $('.subcategoryList > li input[type="checkbox"]').on('change', advanced_search );
    $('.typeList > li input[type="checkbox"]').on('change', advanced_search );


    $(document).on('click' , '.supplier_cards .pagination a', function(e) {


      e.preventDefault();


      var keyword = $('#keyword').val();

      var categories_checked = $('.categoryList > li input[type="checkbox"]').filter(':checked');
      var categories_id = [];

      for (var i = 0; i < categories_checked.length; i++) {
          categories_id[i] = categories_checked[i].value;
      };

      var subcategories_checked = $('.subcategoryList > li input[type="checkbox"]').filter(':checked');
      var subcategories_id = [];

      for (var i = 0; i < subcategories_checked.length; i++) {
          subcategories_id[i] = subcategories_checked[i].value;
      };

      var types_checked = $('.typeList > li input[type="checkbox"]').filter(':checked');
      var types_id = [];

      for (var i = 0; i < types_checked.length; i++) {
          types_id[i] = types_checked[i].value;
      };

      var category_id = $('#category_id').val();
      var type_id = $('#type_id').val();

      if ( search_key == 'search' ) {

        var url = $(this).attr('href');

        getSuppliers(url, keyword,category_id,type_id);

      }else if( search_key == 'advanced_search') {

        var url = $(this).attr('href');

        AdvancedGetSuppliers(url,categories_id, subcategories_id ,types_id);
      }


    });

    function getSuppliers(url, keyword,category_id,type_id) {

          var query = location.href.split('?')[1];

          if (query) {
            query = query.substring(8,  query.indexOf('&') );
          }

          if ( !keyword ) {
            keyword = query
          };


          $.busyLoadFull("show", {

          });

          $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data: {
              keyword,
              category_id,
              type_id,
              search:true,
            },
          })
          .done(function(response) {

            $('.supplier_cards').html(response);

            $('script').last().next().remove();
            $('#keyword').val(keyword);

            search_key = 'search';

          }).fail(function(response){

            $.confirm({
              title: 'Error',
              content: 'You Must Login First',
              type: 'red',
              typeAnimated: true,
              buttons: {

                  close: function () {

                  }
              }
          });

          }).complete(function () {
            $.busyLoadFull("hide", {});
          });


    }

    function AdvancedGetSuppliers(url, categories_id, subcategories_id ,types_id) {

          $.busyLoadFull("show", {});


          $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            data:{
              categories_id:categories_id,
              subcategories_id:subcategories_id,
              types_id:types_id,
              advanced_search:true,
            }
          })
          .done(function(response) {
            console.log(response);
            $('.supplier_cards').html(response);
            $('script').last().next().remove();
            search_key = 'advanced_search';

          }).fail(function(response){

             $.confirm({
              title: 'Error',
              content: 'You Must Login First',
              type: 'red',
              typeAnimated: true,
              buttons: {

                  close: function () {

                  }
              }
          });


          }).complete(function () {
            $.busyLoadFull("hide", {});
          });

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
    <div class="slide slide1" style="background-image: url({{asset('img/banner/moo.jpg')}});">
      <div class="container">
        <div class="slide-inner1 common-inner">
          <span class="h1 from-bottom">Choose your Meal</span>
          <span class="h4 from-bottom">Listty helps to find out great things arround you</span><br>
        </div>
      </div>
    </div>

    <!-- Slide Two -->
    <div class="slide slide2" style="background-image: url({{asset('img/banner/moo.jpg')}});">
      <div class="container">
        <div class="slide-inner2 common-inner">
          <span class="h1 from-bottom">Choose your Meal</span>
          <span class="h4 from-bottom">Listty helps to find out great things arround you</span><br>
        </div>
      </div>
    </div>

    <!-- Slide Three -->
    <div class="slide slideResize slide4" style="background-image: url({{asset('img/banner/moo.jpg')}});">
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
    <div class="status">

    </div>
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
              <button type="submit" class="btn btn-primary search">Search </button>
            </div>
          </form>
        </div>
      </div>
          @endif
    </div>
  </div>
<!-- CATEGORY GRID SECTION -->
<section class="clerfix categoryGrid">

	<div class="container">


    <div class="col-sm-3 col-xs-12">

        @if( advanced_search()['search_with_category'] )
        <div class="sidebarInner sidebarCategory">
          <div class="panel panel-default">
            <div class="panel-heading">
             <i type="button" class="collapse_category fa fa-minus" > </i>
            Category
           </div>
            <div class="panel-body category_search appear">
              <ul class="list-unstyle categoryList">
                @foreach( App\Category::where('parent_id' , null)->get() as $category )
                <li class="checkbox">
                  <label>
                    <input type="checkbox" value="{{ $category->id }}"> {{ $category->name }}
                  </label>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
        @endif

        @if( advanced_search()['search_with_sub_category'] )
        <div class="sidebarInner sidebarCategory">
          <div class="panel panel-default">
            <div class="panel-heading">
              <i type="button" class="collapse_subcategory fa fa-minus" > </i>

              Sub Category
            </div>
            <div class="panel-body subcategory_search appear">
              <ul class="list-unstyle subcategoryList">
                @foreach( App\Category::where('parent_id' , '!=' , null)->get() as $category )
                <li class="checkbox">
                  <label>
                    <input type="checkbox" value="{{ $category->id }}"> {{ $category->name }}
                  </label>
                </li>
                @endforeach
              </ul>
            </div>
          </div>
        </div>
        @endif

    </div>

		<div class="col-sm-9 col-xs-12 supplier_cards">

      <div>
        <div class="resultBar">
					<h2>We found
            <span class="number"> {{ $number_of_suppliers }} </span> Results for you
          </h2>
        </div>

				<div class="rows">

          <div class="row">
            @foreach($suppliers as $supplier)
                    <div class="col-md-4">
                        <div class="card card-product" style="
                            background-color: white;
                            border: 1px;
                            box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.14), 0 3px 1px -2px rgba(0, 0, 0, 0.2), 0 1px 5px 0 rgba(0, 0, 0, 0.12);
                              height: 370px;
                            color: rgba(0, 0, 0, 0.87);border-radius: 6px;padding-bottom: 10px;margin-bottom: 15px;
                        ">
                            <div class="card-image" style="width: 90%;margin: auto;">
                                <a href="#" style="color: #9c27b0;text-decoration: none;">
                                  <img style="    width: 100%;
                                    height: 100%;
                                    border-radius: 6px;
                                    pointer-events: none;"
                                    class="img" src="{{ asset('/img/default_supplier.jpg') }}">
                                  </a>
                            </div>
                            <div class="table text-center">
                                <h6 class="category text-rose">{{ $supplier->user->email }}</h6>
                                <h5 class="card-caption">
                                  <a href="{{ route('supplier.profile' , $supplier->id) }}">{{ $supplier->name }}</a>
                                </h5>

                                <div class="ftr">
                                  @if($supplier->phone)
                                    <li>
                                        <a href="#">{{ $supplier->phone }}</a>
                                    </li>
                                  @endif
                                </div>
                            </div>
                        </div>
                    </div>
            @endforeach
          </div>

				</div>
				<div class="paginationCommon blogPagination categoryPagination">
					<nav aria-label="Page navigation">
							{{ $suppliers->links() }}
					</nav>
				</div>

			</div>

		</div>
	</div>
</section>

</div>

  </div>



@endsection()
