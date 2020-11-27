<select name="status" class="form-control approval{{ $id }} {{$status}} ">
	<option value="active" {{$status == 'active' ? 'selected' : ''}} >
		Active
	</option>
	<option value="pending" {{$status == 'pending' ? 'selected' : ''}}>Pending</option>
	<option value="canceled" {{$status == 'canceled' ? 'selected' : ''}}>Canceled</option>
</select>

<script type="text/javascript">

  $('.approval{{ $id }}').on('click', function(e) {

    var PendingUrl = '{{ aurl('/listings/pending/'. $id ) }}';
    var ActiveUrl = '{{ aurl('/listings/active/'. $id) }}';
    var CanceledUrl = '{{ aurl('/listings/canceled/'. $id) }}';

    var url =  '';

    if ( $(this).val() == 'active' ) {

      url = ActiveUrl;

    }else if ( $(this).val() == 'pending' ) {

      url = PendingUrl;

    }else if ( $(this).val() == 'canceled' ) {

      url = CanceledUrl;

    }

    var vm = this;

    $.ajax({
      url: url,
      type: 'GET',
      dataType: 'json',
      data:{
      	_token:'{{ csrf_token() }}'
      }
    })
    .done(function(response) {

      $('#status-{{ $id }}').html(response.response);

      if ( response.response == 'active' ) {

        $(vm).removeClass('pending');
        $(vm).removeClass('canceled');
        $(vm).addClass('active');
        $('#status-{{ $id }}').removeClass('alert-warning');
        $('#status-{{ $id }}').removeClass('alert-danger');
        $('#status-{{ $id }}').addClass('alert-success');

      }else if (response.response == 'pending') {

        $(vm).addClass('pending');
        $(vm).removeClass('canceled');
        $(vm).removeClass('active');
        $('#status-{{ $id }}').addClass('alert-warning');
        $('#status-{{ $id }}').removeClass('alert-danger');
        $('#status-{{ $id }}').removeClass('alert-success');


      }else if (response.response == 'canceled') {

        $(vm).removeClass('pending');
        $(vm).addClass('canceled');
        $(vm).removeClass('active');
        $('#status-{{ $id }}').removeClass('alert-warning');
        $('#status-{{ $id }}').addClass('alert-danger');
        $('#status-{{ $id }}').removeClass('alert-success');
      }

    })
    .fail(function() {
      console.log("error");
    });


  });

</script>