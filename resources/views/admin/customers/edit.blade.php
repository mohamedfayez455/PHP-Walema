@extends('admin.index')


@section('content')


            <div class="box-header">
              <h3 class="box-title">{{ $title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              {!! Form::open(['route' => ['customers.update' , $user->customer->id]  , 'method' => 'PUT', 'files' => true]) !!}
               <div class="form-group">
                {!! Form::label('firstname' ,  'First Name' ) !!}
                {!! Form::text('firstname' , $user->firstname , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('lastname' ,  'Last Name' ) !!}
                {!! Form::text('lastname' , $user->lastname , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('email' ,  'Email' ) !!}
                {!! Form::text('email' , $user->email , ['class' => 'form-control'] ) !!}
              </div>
              @if($user->avatar)
              <img src="{{ Storage::url($user->avatar)}}" width="100px" height="100px">
              @else
              <img src="{{ asset('/img/default_user.png') }}" width="100px" height="100px">
              @endif

              <div class="form-group">
                {!! Form::label('avatar' ,  'Avatar' ) !!}
                {!! Form::file('avatar' , ['class' => 'form-control'] ) !!}
              </div>

              {!! Form::submit( 'Save' , ['class' => 'btn btn-primary'] ) !!}
              {!! Form::close() !!}
            </div>

@endsection