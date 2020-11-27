@extends('admin.index')


@section('content')


              {!! Form::open(['route' => 'suppliers.store' , 'files' => true]) !!}
              <div class="form-group">
                {!! Form::label('firstname' ,  'First Name' ) !!}
                {!! Form::text('firstname' , old('firstname') , ['class' => 'form-control' , 'placeholder'=> 'First Name'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('lastname' ,  'Last Name' ) !!}
                {!! Form::text('lastname' , old('lastname') , ['class' => 'form-control' , 'placeholder'=> 'Last Name'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('email' ,  'Email' ) !!}
                {!! Form::text('email' , old('email') , ['class' => 'form-control' , 'placeholder'=> 'Email'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('avatar' ,  'avatar' ) !!}
                {!! Form::file('avatar' , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('password' ,  'Password' ) !!}
                {!! Form::password('password' , ['class' => 'form-control' , 'placeholder'=> 'Password'] ) !!}
              </div>

              {!! Form::submit( 'Create Supplier' , ['class' => 'btn btn-primary'] ) !!}
              {!! Form::close() !!}

@endsection