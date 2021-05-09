@extends('layouts.dashboardLayout')

@section('title')
   Add Driver
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
      Add Driver
    </div>
    <div class="card-body">
      @if(auth("admin")->user()->type=="admin")
        <form method="post" enctype= "multipart/form-data" action="/_admin/addDriver">
      @else
        <form method="post" enctype= "multipart/form-data" action="/_company/addDriver">
      @endif
        @csrf

        <div class="mb-3">
          <label for="formFile" class="form-label">Driver Image</label>
          <input class="form-control" required name="image" type="file" id="formFile">
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Driver Name</label>
          <input type="text" class="form-control" value="{{ old('name') }}" name="name" required id="formGroupExampleInput">
        </div>
        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Phone</label>
          <input type="number" class="form-control" name="phone" value="{{ old('phone') }}" required id="formGroupExampleInput" >
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Country Code</label>
          <input type="text" class="form-control" name="country_code" value="{{ old('country_code') }}" required id="formGroupExampleInput" >
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Email</label>
          <input type="email" class="form-control" name="email" value="{{ old('email') }}"  id="formGroupExampleInput" >
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Password</label>
          <input type="password" class="form-control" name="password" value="{{ old('password') }}" required id="formGroupExampleInput" >
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Car Name</label>
          <input type="text" class="form-control" name="car_name" value="{{ old('car_name') }}" required id="formGroupExampleInput" >
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Car Model</label>
          <input type="text" class="form-control" name="car_model" value="{{ old('car_model') }}" required id="formGroupExampleInput" >
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Car License Number</label>
          <input type="text" class="form-control" name="car_license_number" value="{{ old('car_license_number') }}" required  id="formGroupExampleInput" >
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Activation</label>
          <select class="form-select" id="formGroupExampleInput" required name="is_active" aria-label="Default select example">
            <option disabled value="" selected>Choose...</option>
            @if(old('is_active'))
              @if(old('is_active')==1)
                <option value="1" selected>Active</option>
              @elseif(old('is_active')==0)
                <option value="0" selected>Inactive</option>
              @endif
            @else
              <option value="1" >Active</option>
              <option value="0" >Inactive</option>
            @endif
          </select>
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Language</label>
          <select class="form-select" id="formGroupExampleInput" required name="language" aria-label="Default select example">
            <option disabled value="" selected>Choose...</option>
            @if(old('language'))
              @if(old('language')==1)
                <option value="ar" selected>Arabic</option>
              @elseif(old('language')==0)
                <option value="en" selected>English</option>
              @endif
            @else
              <option value="ar" >Arabic</option>
              <option value="en" >English</option>
            @endif
          </select>
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Truck Type</label>
          <select class="form-select" id="formGroupExampleInput" required name="trucks_types_id" aria-label="Default select example">
            <option disabled value="" selected>Choose...</option>
            @foreach($trucks_types as $truck)
              @if(old('trucks_types_id'))
                @if(old('trucks_types_id')==$truck->id)
                  <option value="{{ $truck->id }}" selected>{{ $truck->name_en }}</option>
                @else

                  <option value="{{ $truck->id }}">{{ $truck->name_en }}</option>
                @endif
              @else
                  <option value="{{ $truck->id }}">{{ $truck->name_en }}</option>
              @endif
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Fees</label>
          <input type="number" class="form-control" name="fees" value="{{ old('fees') }}"  id="formGroupExampleInput" >
        </div>

        <div class="mb-3">
          <label for="formFile" class="form-label">Driving License Image</label>
          <input class="form-control" required name="driving_license_image" required value="{{old('driving_license_image')}}" type="file" id="formFile">
        </div>

        <div class="mb-3">
          <label for="formFile" class="form-label">Car License Image</label>
          <input class="form-control" required name="car_license_image" required value="{{old('car_license_image')}}" type="file" id="formFile">
        </div>

        <div class="mb-3">
          <label for="formFile" class="form-label">Idetification Image</label>
          <input class="form-control" required name="id_image" required value="{{old('id_image')}}" type="file" id="formFile">
        </div>

        <div class="mb-3">
          <label for="formFile" class="form-label">Car Photo</label>
          <input class="form-control" required name="car_photo" required value="{{old('car_photo')}}" type="file" id="formFile">
        </div>


        <button type="submit" name="addDriver" class="btn btn-outline-primary float-end">
          Add Driver <i class="fas fa-plus-square"></i>
        </button>
      </form>
    </div>
  </div>

@stop



