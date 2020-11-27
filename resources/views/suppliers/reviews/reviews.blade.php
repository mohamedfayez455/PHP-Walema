@extends('layouts.app')

@section('content')

@push('css')

  <style>

    .pagination {
      margin-left: -115px;
      font-size: 19px;
      position: fixed;
      bottom: 160px;

    }

  </style>

@endpush

@push('js')
<script type="text/javascript">

  $(window).load(function() {

    removeSingleList();

    url = '{{ URL::Current() . '/' }}';

    AjaxRequest(url);

  });

  $(document).on('click' ,  '.sbOptions li > a' , function(e) {

    e.preventDefault();

    var id = '' , url = '';

    id = $(this).attr('href').split(/#/)[1];

    url = '{{ URL::Current() }}';

    var test = url.split('/');

    var check = test[ test.length -1 ];

    if (check && id == check) {
      url = '{{ URL::Current() . '/' }}';
    }else {
      url = '{{ URL::Current() . '/' }}' + id;
    }

    removeSingleList();

    AjaxRequest(url);


  });

    $(document).on('click' ,  '.pagination li > a' , function(e) {

    e.preventDefault();

    url = $(this).attr('href');

    removeSingleList();

    AjaxRequest(url);


  });

  function AjaxRequest(url){


    $.ajax({
      url: url,
      type: 'get',
      dataType: 'json',
    })
    .done(function(response) {

      removeSingleList();

    $('.visitor_reviews').append(response.visitor_reviews);
    $('.your_reviews').append(response.your_reviews);

    })
    .fail(function(error) {
      console.log(error);
    });

  }

  function removeSingleList () {


    var myList = document.querySelectorAll('.visitor_reviews .single-list');
    myList.forEach(function (singleList) {

      $(singleList).remove();
      $('.pagination').remove();

    });

    myList = document.querySelectorAll('.your_reviews .single-list');
    myList.forEach(function (singleList) {

      $(singleList).remove();
      $('.pagination').remove();

    });

  }

  $(document).on('click' , '.reply_to' , function(){

    $('#reply_modal').modal('show');

    $('#reply_modal .name').html( $(this).data('name') );

    $('#reply_modal #review_id').val( $(this).attr('id') );

  });

$(document).on('click' , '.reply_to' , function(){

    $('#reply_modal').modal('show');

    $('#reply_modal .name').html( $(this).data('name') );

    $('#reply_modal #review_id').val( $(this).attr('id') );

  });

  $(document).on('click' , '.replyBtn' , function(e){

    e.preventDefault();

    var data = $('#reply_form').serialize();
    var review_id = $('#reply_modal #review_id').val();

    $.ajax({

      url:'{{ url('/supplier/reply/review') }}',
      type:'GET',
      data:data,
      success:function(response){
        $('#reply_modal').modal('hide');

        $('.replies_num_' + review_id).html(response);


        $('#reply_modal .body').val('');
        $('#reply_modal #review_id').val('')

      }

    });

  });





</script>

@endpush

<div id="reply_modal" tabindex="-1" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reply To <span class="name"></span> </h4>
      </div>
      <div class="modal-body">
        <form id="reply_form">
          {{ csrf_field() }}

          <div class="form-group">
            <label>Reply</label>
            <textarea class="form-control body" name="body" placeholder="Reply"></textarea>
          </div>

          <input type="hidden" name="review_id" id="review_id">

          <div class="form-group">
            <button type="submit" class="btn btn-primary replyBtn btn-block">Reply</button>
          </div>

        </form>
      </div>
    </div>

  </div>
</div>


<!-- Dashboard breadcrumb section -->
<section class="clearfix bg-dark listyPage">
<div class="section dashboard-breadcrumb-section bg-dark">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h2>Review</h2>
        <ol class="breadcrumb">
          <li><a href="/">Home</a></li>
          <li><a href="{{route('dashboard')}}">Dashboard</a></li>
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
        <div class="dashboard-list-box visitor-list">
          <div class="list-sort">
            <div class="sort-left">Visitor Reviews</div>
            <div class="sort-right sort-select">
              <select name="listings" id="listings" class="select-drop">
                @if( !empty( $lsitings->toArray() ) )
                <option value=""> All Listings</option>
                @endif

                @forelse( $lsitings as $lsiting )

                <option value="{{ $lsiting->id }}">
                  {{ $lsiting->name }}
                </option>
                @empty
                <option>No Listing Yet</option>

                @endforelse
              </select>
            </div>
          </div>

          <div class="visitor_reviews"></div>

        </div>
      </div>
      <div class="col-xs-12 col-lg-6">
        <div class="dashboard-list-box your-list">
          <div class="list-sort">
            <div class="sort-left">Your Reviews</div>
          </div>
          <div class="your_reviews"></div>
        </div>
      </div>
    </div>



  </div>
</section>

</div>

  </div>
@endsection
