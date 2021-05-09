@extends('layouts.dashboardLayout')

@section('title')
   Edit Price
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
      Edit Price
    </div>
    <div class="card-body">
      <form method="post" enctype= "multipart/form-data" action="/_admin/updatePrice/{{$price->id}}">
        @csrf
        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Distance</label>
          <input type="text" class="form-control" value="{{ $price->category }}" name="category" required id="formGroupExampleInput">
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Price</label>
          <input type="number" class="form-control" value="{{ $price->price }}" name="price" required id="formGroupExampleInput">
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Truck Type</label>
          <select class="form-select" id="formGroupExampleInput" required name="trucks_types_id" aria-label="Default select example">
            <option disabled value="" selected>Choose...</option>
            @foreach($trucks_types as $truck)
              @if($price->trucks_types_id==$truck->id)
                <option value="{{$truck->id}}" selected>{{ $truck->name_en }}</option>
              @else
                <option value="{{$truck->id}}">{{$truck->name_en}}</option>
              @endif
            @endforeach
          </select>
        </div>

       
        
        <button type="submit" name="addPrice" class="btn btn-outline-success float-end">
          Update 
        </button>
      </form>
    </div>
  </div>
@endsection