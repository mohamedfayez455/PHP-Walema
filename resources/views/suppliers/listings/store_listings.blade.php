@extends('layouts.app')

@section('content')

@push('js')

	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>


	<script type="text/javascript">

		window.Dropzone;
		Dropzone.autoDiscover = false;

		$('#uploadedPhotos').dropzone({
			url: '{{ url('/upload/image/' . $listing->id ) }}',
			paramName:'photo',
			maxFilesize:5,
			maxFiles:10,
			uploadMultiple:false,
			acceptedFiles:'image/*',
			dictDefaultMessage:'Click Or Drop Images here to upload',
			dictRemoveFile:'Delete Images',
			addRemoveLinks:true,
			autoProccessQueue:true,
			params:{
				_token:'{{ csrf_token() }}'
			},
			removedfile:function(file) {

				$.ajax({
					url: '/delete/image/' + file.id,
					type: 'delete',
					dataType: 'json',
					data: {_token: '{{ csrf_token() }}'},
				});

				var currentFile = file.previewElement;

				return (currentFile != null) ? currentFile.parentNode.removeChild(currentFile) : void 0 ;

			},
			init:function() {

				@foreach($listing->files as $file)

					var f = { id:'{{ $file->id }}' , name:'{{ $file->name }}' , size:'{{ $file->size }}' , type: '{{ $file->mime_type }}'  };

					this.removeAllFiles();

					this.emit('addedFile' , f);
	                this.options.addedfile.call(this, f);
	                this.options.thumbnail.call(this, f, '{{ Storage::url($file->full_path) }}');

				@endforeach

				this.on('addedFile', function(file , response) {

					if (response) {
						file.id = response.id;
					}
				});


			}

		});

		$('#uploadedMainPhoto').dropzone({
			url: '{{ url('/upload/main/image/' . $listing->id ) }}',
			paramName:'main_photo',
			maxFilesize:5,
			maxFiles:1,
			uploadMultiple:false,
			acceptedFiles:'image/*',
			dictDefaultMessage:'Click Or Drop Main Image here to upload',
			dictRemoveFile:'Delete Main Image',
			addRemoveLinks:true,
			autoProccessQueue:true,
			params:{
				_token:'{{ csrf_token() }}'
			},
			removedfile:function(file) {

				$.ajax({
					url: '{{ url('/delete/main/image/' . $listing->id ) }}',
					type: 'delete',
					dataType: 'json',
					data: {_token: '{{ csrf_token() }}'},
				});

				var currentFile = file.previewElement;

				return (currentFile != null) ? currentFile.parentNode.removeChild(currentFile) : void 0 ;

			},
			init:function() {

				@if($listing->main_photo)

					var f = { name:'{{ $listing->name }}' , size:'' , type: ''  };

					this.removeAllFiles();

					this.emit('addedFile' , f);
	                this.options.addedfile.call(this, f);
	                this.options.thumbnail.call(this, f, '{{ Storage::url($listing->main_photo) }}');
	                $('.dz-progress').remove();
				@endif

			}

		});


	</script>



	<script type="text/javascript" src="{{ url('/dist/locationpicker/locationpicker.jquery.min.js') }}"></script>


	<?php

$latitude = old('latitude') ? old('latitude') : $listing->latitude;
$latitude = empty($latitude) ? '30.061291199759854' : $latitude;

$longitude = old('longitude') ? old('longitude') : $listing->longitude;
$longitude = empty($longitude) ? '31.219255447387695' : $longitude;
?>

	<script>

        $('#map').locationpicker({
          location: {
              latitude: {{ $latitude }},
              longitude: {{ $longitude }}
          },
            radius: 300,
            markerIcon: '{{ url('/img/map-marker-2-xl.png') }}',
            inputBinding: {
            latitudeInput: $('#latitude'),
            longitudeInput: $('#longitude'),
            //radiusInput: $('#us2-radius'),
            locationNameInput: $('.address')
          }
        });


      </script>

      <style type="text/css">
      	.dz-image img{
			width: 100px;
			height: 100px;
		}
      </style>
@endpush

<!-- Dashboard breadcrumb section -->



<section class="clearfix bg-dark listyPage">

<!-- Dashboard breadcrumb section -->
<div class="section dashboard-breadcrumb-section bg-dark">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <h2>
        	{{ ( $listing->name == null && $listing->description == null ? 'Add Listing' : 'Edit Listing') }}
        </h2>
        <ol class="breadcrumb">
          <li><a href="/">Home</a></li>
          <li><a href="{{route('dashboard')}}">Dashboard</a></li>
          <li class="active">
          	{{ ( $listing->name == null && $listing->description == null ? 'Add Listing' : 'Edit Listing') }}
      	  </li>
        </ol>
      </div>
    </div>
  </div>
</div>


<!-- DASHBOARD ORDERS SECTION -->
<section class="clearfix bg-dark listingSection">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<form action="{{ route('suppliers.store_listing' , $listing->id) }}" method="POST" class="listing__form">
					{{ csrf_field() }}
					<div class="dashboardBoxBg mb30">
						<div class="profileIntro paraMargin">
							<h3>About</h3>
							<p>We are not responsible for any damages caused by the use of this website, or by posting business listings here. Please use our site at your own discretion and exercise good judgement as well as common sense when advertising business here.</p>
							<div class="row">
								<div class="form-group col-sm-6 col-xs-12">
									<label for="name">Listing Name</label>
									<input type="text" class="form-control" id="name" name="name" value="{{ $listing->name }}">
								</div>
								<div class="form-group col-sm-6 col-xs-12">
									<label for="listingCategory">Category</label>
									<div class="contactSelect">
										<select name="category_id" id="category_id" class="select-drop">

											@forelse( \App\Category::pluck('name' , 'id') as $id => $name )
												<option value="{{ $id }}">{{ $name }}</option>
											@empty
												<option value="0">There Are No Categories Yes</option>
											@endforelse

										</select>
									</div>
								</div>
								<div class="form-group col-xs-12">
									<label for="description">Discribe the listing</label>
									<textarea class="form-control" name="description" rows="3" placeholder="Discribe the listing"> {{ $listing->description }} </textarea>
								</div>
								<div class="form-group col-sm-6 col-xs-12">
									<label for="tags">Tags <small class="text-info">( separate between tage with <strong>,</strong> or space )</small> </label>
									<input type="text" class="form-control" id="tags" name="tags" value="{{ $listing->tags }}">
								</div>

								<div class="form-group col-sm-6 col-xs-12">
									<label for="price">price	</label>
									<input type="text" class="form-control" id="price" name="price" value="{{$listing->price }}">
								</div>

							</div>
						</div>
					</div>

					<div class="dashboardBoxBg mb30">
						<div class="profileIntro paraMargin">
							<h3>Main Photo</h3>
							<div class="dropzone" id="uploadedMainPhoto"></div>
						</div>
					</div>


					<div class="dashboardBoxBg mb30">
						<div class="profileIntro paraMargin">
							<h3>Gallery</h3>
							<div class="dropzone" id="uploadedPhotos"></div>
						</div>
					</div>

					</div>

					<div class="form-footer text-center">
						<button type="submit" class="btn btn-primary" style="width: 200px">{{ ( $listing->name == null && $listing->description == null ? 'Add Listing' : 'Edit Listing') }} </button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
</div>

  </div>
  @endsection()
