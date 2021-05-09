@extends('layouts.dashboardLayout')

@section('title')
   Add Price
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
      Add Price
    </div>
    <div class="card-body">
      <form method="post" enctype= "multipart/form-data" action="/_admin/addPrice">
        @csrf
        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Distance</label>
          <input type="text" class="form-control" value="{{ old('category') }}" name="category" required id="formGroupExampleInput">
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Price</label>
          <input type="number" class="form-control" value="{{ old('price') }}"  name="price" required id="formGroupExampleInput">
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Truck Type</label>
          <select class="form-select" id="formGroupExampleInput" required name="trucks_types_id" aria-label="Default select example">
            <option disabled value="" selected>Choose...</option>
            @foreach($trucks_types as $truck)
                <option value="{{$truck->id}}">{{$truck->name_en}}</option>
            @endforeach
          </select>
        </div>

       
        
        <button type="submit" name="addPrice" class="btn btn-outline-primary float-end">
          Add <i class="fas fa-plus"></i> 
        </button>
      </form>
    </div>
  </div>
@endsection