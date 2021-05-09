@extends('layouts.dashboardLayout')

@section('title')
   Add Contact Type
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
      Add Contact Type
    </div>
    <div class="card-body">
      <form method="post" enctype= "multipart/form-data" action="/_admin/addContactType">
        @csrf

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Name</label>
          <input type="text" class="form-control" value="{{ old('name') }}" name="name" required id="formGroupExampleInput">
        </div>
        
        <button type="submit" name="addContactType" class="btn btn-outline-primary float-end">
          Add <i class="fas fa-plus-square"></i>
        </button>
      </form>
    </div>
  </div>
@endsection