@extends('admin.index')

@section('content')


              {!! Form::open(['route' => 'supplier-types.store' , 'files' => true]) !!}
              <div class="form-group">
                {!! Form::label('name' ,  'Name' ) !!}
                {!! Form::text('name' , old('name') , ['class' => 'form-control'] ) !!}
              </div>

              <div class="form-group">
                {!! Form::label('slug' ,  'Slug' ) !!}
                {!! Form::text('slug' , old('slug') , ['class' => 'form-control'] ) !!}
              </div>


              <div class="form-group">
                {!! Form::label('photo' ,  'photo' ) !!}
                {!! Form::file('photo' , ['class' => 'form-control'] ) !!}
              </div>


              <div class="form-group">
                {!! Form::label('desc' ,  'Description' ) !!}
                {!! Form::textarea('desc' , old('desc') , ['class' => 'form-control'] ) !!}
              </div>

              {!! Form::submit( 'Create Supplier Type' , ['class' => 'btn btn-primary'] ) !!}
              {!! Form::close() !!}

@endsection