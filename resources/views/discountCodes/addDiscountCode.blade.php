@extends('layouts.dashboardLayout')

@section('title')
   Add Dicount Code 
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
      Add Dicount Code
    </div>
    <div class="card-body">
      <form method="post" enctype= "multipart/form-data" action="/_admin/addDiscountCode">
        @csrf
        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Code</label>
            <div class="input-group mb-3">
              <input type="number" class="form-control" id="CodeInput" maxlength="5" name="code" value="{{ old('code') }}" required aria-describedby="button-addon2">
              <button class="btn btn-secondary" type="button" id="randomCode">Random</button>
            </div> 
        </div>


        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Discount Percentage</label>
          <div class="input-group flex-nowrap">
            <input type="number" class="form-control" name="discount"  value="{{old('discount')}}" aria-describedby="addon-wrapping">
            <span class="input-group-text" id="addon-wrapping">%</span>
          </div>
        </div>
        
        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Count</label>
          <input type="number" class="form-control" value="{{ old('count') }}" required name="count"  id="formGroupExampleInput">
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Date</label>
          <input type="datetime-local" required class="form-control"name="end_date" value="{{old('end_date')}}"  title="Choose End Date">
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
        <br>
        <button type="submit" name="addContactType" class="btn btn-outline-primary float-end">
          Add <i class="fas fa-plus-square"></i>
        </button>
      </form>
    </div>
  </div>
@endsection