@extends('layouts.dashboardLayout')

@section('title')
   Edit Truck Type
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
      Edit Truck Type
    </div>
    <div class="card-body">
      <form method="post" enctype= "multipart/form-data" action="/_admin/updatetTruckType/{{$truckType->id}}">
        @csrf

        <div class="mb-3">
          <div id="badr" class="d-flex align-items-center edit-image">
            <a href="{{ $truckType->image }}" target="_blank"><img src="{{ $truckType->image }}" ></a>
            <div class="d-flex flex-column ">
              <label for="formGroupExampleInput" class="form-label">Image</label>
              <input class="form-control"  name="image" type="file" id="formFile" onchange="previewImage(this);">
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Name</label>
          <input type="text" class="form-control" value="{{ $truckType->name_en }}"  name="name" required id="formGroupExampleInput">
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Descriptions</label>
          <input type="text" class="form-control" value="{{ $truckType->descriptions_en }}"  name="descriptions_en" required id="formGroupExampleInput">
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Max Weight</label>
          <input type="number" class="form-control" value="{{ $truckType->max_weight }}"  name="max_weight" required id="formGroupExampleInput">
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Area</label>
          <input type="number" class="form-control" value="{{ $truckType->area }}"  name="area" required id="formGroupExampleInput">
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Activation</label>
          <select class="form-select" id="formGroupExampleInput" required name="is_active" aria-label="Default select example">
            <option disabled value="" selected>Choose...</option>
            @if($truckType->is_active==1)
              <option value="1" selected>Active</option>
              <option value="0" >Inactive</option>
            @elseif($truckType->is_active==0)
              <option value="0" selected>Inactive</option>
              <option value="1" >Active</option>
            @endif
          </select>
        </div>

      

       
        
        <button type="submit" name="addPrice" class="btn btn-success float-end">
          Update
        </button>
      </form>
    </div>
  </div>
@endsection