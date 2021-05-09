@extends('layouts.dashboardLayout')

@section('title')
   Add Truck Types
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
      Add Truck Type
    </div>
    <div class="card-body">
      <form method="post" enctype= "multipart/form-data" action="/_admin/addTruckType">
        @csrf

        <div class="mb-3">
          <label for="formFile" class="form-label">Image</label>
          <input class="form-control" required name="image" type="file" id="formFile">
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Name</label>
          <input type="text" class="form-control" value="{{ old('name') }}"  name="name" required id="formGroupExampleInput">
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Descriptions</label>
          <input type="text" class="form-control" value="{{ old('descriptions_en') }}"  name="descriptions_en" required id="formGroupExampleInput">
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Max Weight</label>
          <input type="number" class="form-control" value="{{ old('max_weight') }}"  name="max_weight" required id="formGroupExampleInput">
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Area</label>
          <input type="number" class="form-control" value="{{ old('area') }}"  name="area" required id="formGroupExampleInput">
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Activation</label>
          <select class="form-select" id="formGroupExampleInput" required name="is_active" aria-label="Default select example">
            <option disabled value="" selected>Choose...</option>
            @if(old('is_active'))
              @if(old('is_active')==1)
                <option value="1" selected>Active</option>
                <option value="0" >Inactive</option>
              @elseif(old('is_active')==0)
                <option value="0" selected>Inactive</option>
                <option value="1" >Active</option>
              @endif
            @else
              <option value="1" >Active</option>
              <option value="0" >Inactive</option>
            @endif
          </select>
        </div>

      

       
        
        <button type="submit" name="addPrice" class="btn btn-outline-primary float-end">
          Add <i class="fas fa-plus"></i> 
        </button>
      </form>
    </div>
  </div>
@endsection