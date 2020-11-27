@extends('admin.index')

@section('content')


            <div class="box-header">
              <h3 class="box-title">{{ $title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              {!! Form::open(['route' => ['admins.update' , $admin->id]  , 'method' => 'PUT', 'files' => true]) !!}
               <div class="form-group">
                {!! Form::label('firstname' ,  'First Name' ) !!}
                {!! Form::text('firstname' , $admin->firstname , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('lastname' ,  'Last Name' ) !!}
                {!! Form::text('lastname' , $admin->lastname , ['class' => 'form-control'] ) !!}
              </div>


              <div class="form-group">
                {!! Form::label('email' ,  'Email' ) !!}
                {!! Form::email('email' , $admin->email , ['class' => 'form-control'] ) !!}
              </div>

              @if($admin->photo)
                <img src="{{ $admin->photo }}" width="50px" height="50px">
              @endif

              <div class="form-group">
                {!! Form::label('photo' ,  'Photo' ) !!}
                {!! Form::file('photo' , ['class' => 'form-control'] ) !!}
              </div>

              {!! Form::submit( 'Save' , ['class' => 'btn btn-primary'] ) !!}
              {!! Form::close() !!}
            </div>

@endsection