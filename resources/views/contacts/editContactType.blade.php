@extends('layouts.dashboardLayout')

@section('title')
   Edit Contact Type
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
      Edit Contact Type
    </div>
    <div class="card-body">
      <form method="post" enctype= "multipart/form-data" action="/_admin/updatetContactType/{{$contactType->id}}">
        @csrf
        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Name</label>
          <input type="text" class="form-control" value="{{ $contactType->name_en }}" name="name" required id="formGroupExampleInput">
        </div>
        
        <button type="submit" name="editContactType" class="btn btn-outline-success float-end">
          Update 
        </button>
      </form>
    </div>
  </div>
@endsection