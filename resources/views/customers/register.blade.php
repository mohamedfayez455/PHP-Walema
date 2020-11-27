@extends('layouts.app')


@push('css')
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/dist/select2/css/select2.min.css">
@endpush

@push('js')

  <script  src="{{url('/')}}/dist/select2/js/select2.min.js"></script>

  <script src="{{url('/')}}/admin_design/js/show_form_builder.js"></script>


  <script src="{{url('/')}}/admin_design/js/form_builder_add_field.js"></script>

  <script>

  $(function() {

    var url = '{{ route("front_customers_profile_builder.get_profile_builder") }}/';
    showFormBuilder(url , '.signUpFormBuilder' , 'signup');

  });

  </script>

@endpush

@section('content')


<div class="container">
  <section class="clearfix signUpSection">
  	<div class="container">
  		<div class="row">
  			<div class="col-sm-8 col-xs-12">
  				<div class="signUpFormArea">
  					<div class="priceTableTitle">
  						<h2>Customer Registration</h2>
  						<p>Please fill out the fields below to create your account. We will send your account information to the email address you enter. Your email address and information will NOT be sold or shared with any 3rd party. If you already have an account, please, <a href="{{route('login')}}">click here</a>.</p>
  					</div>
  					<div class="signUpForm">
  						<form method="POST" action="{{ route('customers.register') }}" class="signUpFormBuilder">
  								{{ csrf_field() }}


  						</form>
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>
  </section>
</div>
@endsection


