@extends('layouts.dashboardLayout')

@section('title')
   Edit Admin  
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
      Edit Admin
    </div>
    <div class="card-body">
      <form method="post" enctype= "multipart/form-data" action="/_admin/updateAdmin/{{$admin->id}}">
        @csrf
        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Name</label>
          <input type="text" class="form-control" value="{{ $admin->name }}" name="name" required id="formGroupExampleInput">
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Email</label>
          <input type="email" class="form-control" value="{{ $admin->email  }}" name="email" required id="formGroupExampleInput">
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Password</label>
          <div class="input-group mb-3">
            <input type="password" class="form-control" name="password">
            <button class="btn btn-outline-secondary" type="button" id="show-password"><i class="fas fa-eye-slash"></i></button>
          </div>
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Phone</label>
          <input type="number" class="form-control" value="{{ $admin->phone }}" name="phone" required id="formGroupExampleInput">
        </div>


        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Type</label>
          <select class="form-select" id="formGroupExampleInput" required name="type" aria-label="Default select example">
            <option disabled value="" selected>Choose...</option>
            @if($admin->type=='admin')
              <option value="admin" selected>Admin</option>
              <option value="company" >Company</option>
            @elseif($admin->type=="company")
              <option value="company" selected>Company</option>
              <option value="admin" >Admin</option>
            @endif
          </select>
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Role</label>
          <select class="form-select" id="formGroupExampleInput" required name="role" aria-label="Default select example">
            <option disabled value="" selected>Choose...</option>
            @if($admin->role=='add')
              <option value="add" selected>Add</option>
              <option value="edit" >Edit</option>
              <option value="delete" >Delete</option>
            @elseif($admin->role)=="edit")
              <option value="add">Add</option>
              <option value="edit" selected>Edit</option>
              <option value="delete" >Delete</option>
            @elseif($admin->role)=="delete")
              <option value="add">Add</option>
              <option value="edit" >Edit</option>
              <option value="delete" selected >Delete</option>
            @endif
          </select>
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Activation</label>
          <select class="form-select" id="formGroupExampleInput" required name="is_active" aria-label="Default select example">
            <option disabled value="" selected>Choose...</option>
            @if($admin->is_active==1)
              <option value="1" selected>Active</option>
              <option value="0" >Inactive</option>
            @elseif($admin->is_active==0)
              <option value="0" selected>Inactive</option>
              <option value="1" >Active</option>
            @endif
          </select>
        </div>
        <br>
        <button type="submit" name="addContactType" class="btn btn-outline-success float-end">
          Update 
        </button>
      </form>
    </div>
  </div>
@endsection