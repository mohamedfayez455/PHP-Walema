<a class="btn btn-{{ $approved == '0' ? 'info approve' : 'danger unapprove' }} approval{{ $id }}">
	{{ $approved == '0' ? 'Approve' : 'Unapprove' }}
</a>

<script type="text/javascript">

  $('.approval{{ $id }}').on('click', function(e) {

    var ApprovedUrl = '{{ aurl('/supplier/approve/'. $id ) }}';
    var UnApprovedUrl = '{{ aurl('/supplier/unapprove/'. $id) }}';
    var url =  '';

    if ( $(this).hasClass('approve') ) {

      url = ApprovedUrl;

    }else if ( $(this).hasClass('unapprove') ) {

      url = UnApprovedUrl;

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

      if ( response.response == 'approved' ) {
        $(vm).removeClass('approve');
        $(vm).addClass('btn-info');
        $(vm).addClass('unapprove');
        $(vm).addClass('btn-danger');
        $(vm).html('Unapprove');
      }else if (response.response == 'unapproved') {
        $(vm).removeClass('unapprove');
        $(vm).removeClass('btn-danger');
        $(vm).addClass('approve');
        $(vm).html('Approve');
        $(vm).addClass('btn-info');
      }

    })
    .fail(function() {
      console.log("error");
    });


  });

</script>