@extends('layouts.dashboardLayout')

@section('title')
   Edit Driver
@endsection

@section('page_content')
    @if($errors->any())
      @foreach ($errors->all() as $error)
        <div class="alert alert-danger">      
          {{ $error }}
        </div>
      @endforeach
   @endif

   @if(session('action'))
   		<div class="alert alert-success">      
          {{ session('action') }}
        </div>
   @endif
   
   <div class="card">
    <div class="card-header">
      Edit Driver
    </div>
    <div class="card-body">
      <form method="post" enctype= "multipart/form-data" action="/_admin/updateDriver/{{$driver->id}}">
        @csrf

        <div class="mb-3">
          <div id="badr" class="d-flex align-items-center edit-image">
            <a href="{{ $driver->image }}" target="_blank"><img src="{{ $driver->image }}" ></a>
            <div class="d-flex flex-column ">
              <label for="formGroupExampleInput" class="form-label">Driver Image</label>
              <input class="form-control"  name="image" type="file" id="formFile" onchange="previewImage(this);">
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Driver Name</label>
          <input type="text" class="form-control" value="{{ $driver->name }}" name="name" required id="formGroupExampleInput">
        </div>
        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Phone</label>
          <input type="number" class="form-control" name="phone" value="{{ $driver->phone }}" required id="formGroupExampleInput" >
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Country Code</label>
          <input type="text" class="form-control" name="country_code" value="{{ $driver->country_code }}" required id="formGroupExampleInput" >
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Email</label>
          <input type="email" class="form-control" name="email" value="{{ $driver->email }}"  id="formGroupExampleInput" >
        </div>

        <!-- <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" value="{{ $driver->password }}" required id="formGroupExampleInput" >
        </div> -->

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Car Name</label>
          <input type="text" class="form-control" name="car_name" value="{{ $driver->car_name }}" required id="formGroupExampleInput" >
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Car Model</label>
          <input type="text" class="form-control" name="car_model" value="{{ $driver->car_model }}" required id="formGroupExampleInput" >
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Car License Number</label>
          <input type="text" class="form-control" name="car_license_number" value="{{ $driver->car_license_number }}" required  id="formGroupExampleInput" >
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Activation</label>
          <select class="form-select" id="formGroupExampleInput" required name="is_active" aria-label="Default select example">
            <option disabled value="" selected>Choose...</option>
              @if($driver->is_active==1)
                <option value="1" selected>Active</option>
              @else
                <option value="0" selected>Inactive</option>
              @endif
          </select>
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Language</label>
          <select class="form-select" id="formGroupExampleInput" required name="language" aria-label="Default select example">
            <option disabled value="" selected>Choose...</option>
            @if($driver->language=="en")
                <option value="en" selected>English</option>
              @else
                <option value="ar" selected>Arabic</option>
            @endif
          </select>
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Truck Type</label>
          <select class="form-select" id="formGroupExampleInput" required name="trucks_types_id" aria-label="Default select example">
            <option disabled value="" selected>Choose...</option>
            @foreach($trucks_types as $truck)
              @if($driver->trucks_types_id==$truck->id)
                <option value="{{$truck->id}}" selected>{{$truck->name_en}}</option>
              @else
                <option value="{{$truck->id}}">{{$truck->name_en}}</option>
              @endif
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Fees</label>
          <input type="number" class="form-control" name="fees" value="{{ $driver->fees}}"  id="formGroupExampleInput" >
        </div>

        <div class="mb-3">
          <div class="d-flex align-items-center edit-image">
            <a href="{{ $driver->car_license_image }}" target="_blank"><img src="{{ $driver->car_license_image }}" ></a>
            <div class="d-flex flex-column "> 
              <label for="formFile" class="form-label">Driving License Image</label>
              <input class="form-control"  name="driving_license_image"   type="file" id="formFile">
            </div>
          </div>
        </div>

        <div class="mb-3">
          <div class="d-flex align-items-center edit-image">
            <a href="{{ $driver->car_license_image }}" target="_blank"><img src="{{ $driver->car_license_image }}" ></a>
            <div class="d-flex flex-column ">
              <label for="formFile" class="form-label">Car License Image</label>
              <input class="form-control"  name="car_license_image"   type="file" id="formFile">
            </div>
          </div>
        </div>

        <div class="mb-3">
          <div class="d-flex align-items-center edit-image">
            <a href="{{ $driver->car_license_image }}" target="_blank"><img src="{{ $driver->id_image }}" ></a>
            <div class="d-flex flex-column ">
              <label for="formFile" class="form-label">Idetification Image</label>
              <input class="form-control"  name="id_image"  type="file" id="formFile">
            </div>
          </div>
        </div>

        <div class="mb-3">
          <div class="d-flex align-items-center edit-image">
            <a href="{{ $driver->car_license_image }}" target="_blank"><img src="{{ $driver->car_photo }}" ></a>
            <div class="d-flex flex-column ">
              <label for="formFile" class="form-label">Car Photo</label>
              <input class="form-control"  name="car_photo"   type="file" id="formFile">
            </div>
          </div>
        </div>
        
        <button type="submit" name="addDriver" class="btn btn-outline-success float-end">
          Update 
        </button>
      </form>
    </div>
  </div>
@endsection