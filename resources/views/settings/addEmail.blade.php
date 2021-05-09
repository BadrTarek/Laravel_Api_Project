@extends('layouts.dashboardLayout')

@section('title')
   Add Email
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
      Add Email
    </div>
    <div class="card-body">
      <form method="post" enctype= "multipart/form-data" action="/_admin/addEmail">
        @csrf
        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Email</label>
          <input type="text" class="form-control" value="{{ old('email') }}" name="email" required id="formGroupExampleInput">
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Activation</label>
          <select class="form-select" id="formGroupExampleInput" required name="is_active" aria-label="Default select example">
            <option disabled value="" selected>Choose...</option>
              <option value="1">Active</option>
              <option value="0">Inactive</option>
          </select>
        </div>
        
        <button type="submit" name="addEmail" class="btn btn-outline-primary float-end">
          Add <i class="fas fa-plus"></i> 
        </button>
      </form>
    </div>
  </div>
@endsection