@extends('layouts.app')

@section('content')
<div class="container">
  <section class="clearfix loginSection">
    <div class="container">
      <div class="row">
        <div class="center-block col-md-5 col-sm-6 col-xs-12">
          <div class="panel panel-default loginPanel">
            <div class="panel-heading text-center">Member log in</div>
            <div class="panel-body">
              <form class="loginForm" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="form-group">
                  <label for="email">Email *</label>
                  <input type="email" class="form-control {{ $errors->has('email') ? ' has-error' : '' }}" id="email"  name="email" value="{{ old('email') }}" required autofocus>

                </div>
                <div class="form-group">
                  <label for="userPassword">Password *</label>
                  <input type="password" class="form-control{{ $errors->has('password') ? ' has-error' : '' }}" name="password" id="userPassword">
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-primary pull-left">{{ __('Login') }}</button>
                  <a href="{{ route('forgot_password') }}" class="pull-right link">Forgot Password?</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

</div>


@endsection
