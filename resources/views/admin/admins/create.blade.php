@extends('admin.index')

@section('content')


              {!! Form::open(['route' => 'admins.store' , 'files' => true]) !!}
              <div class="form-group">
                {!! Form::label('firstname' ,  'First Name' ) !!}
                {!! Form::text('firstname' , old('firstname') , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('lastname' ,  'Last Name' ) !!}
                {!! Form::text('lastname' , old('lastname') , ['class' => 'form-control'] ) !!}
              </div>


              <div class="form-group">
                {!! Form::label('email' ,  'Email' ) !!}
                {!! Form::email('email' , old('email') , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('photo' ,  'photo' ) !!}
                {!! Form::file('photo' , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('password' ,  'Password' ) !!}
                {!! Form::password('password' , ['class' => 'form-control'] ) !!}
              </div>

              {!! Form::submit( 'Create Admin' , ['class' => 'btn btn-primary'] ) !!}
              {!! Form::close() !!}

@endsection