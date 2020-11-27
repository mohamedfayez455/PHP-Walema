@extends('admin.index')

@section('content')


            <div class="box-header">
              <h3 class="box-title">{{ $title }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              {!! Form::open(['route' => ['supplier-types.update' , $type->id]  , 'method' => 'PUT', 'files' => true]) !!}
              <div class="form-group">
                {!! Form::label('name' ,  'Name' ) !!}
                {!! Form::text('name' , $type->name , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('slug' ,  'Slug' ) !!}
                {!! Form::text('slug' , $type->slug , ['class' => 'form-control'] ) !!}
              </div>

              <img src="{{ $type->photo_path }}" width="100px" height="100px">

              <div class="form-group">
                {!! Form::label('photo' ,  'photo' ) !!}
                {!! Form::file('photo' , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('desc' ,  'Description' ) !!}
                {!! Form::text('desc' , $type->desc , ['class' => 'form-control'] ) !!}
              </div>

              {!! Form::submit( 'Save' , ['class' => 'btn btn-primary'] ) !!}
              {!! Form::close() !!}
            </div>

@endsection