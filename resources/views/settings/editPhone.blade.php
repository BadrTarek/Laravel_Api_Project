@extends('layouts.dashboardLayout')

@section('title')
   Edit Phone
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
      Edit Phone
    </div>
    <div class="card-body">
      <form method="post" enctype= "multipart/form-data" action="/_admin/updatePhone/{{$phone->id}}">
        @csrf
        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Phone</label>
          <input type="text" class="form-control" value="{{ $phone->phone }}" name="phone" required id="formGroupExampleInput">
        </div>

        <div class="mb-3">
          <label for="formGroupExampleInput" class="form-label">Activation</label>
          <select class="form-select" id="formGroupExampleInput" required name="is_active" aria-label="Default select example">
            <option disabled value="" selected>Choose...</option>
              @if($phone->is_active ==1)
                <option value="1" selected>Active</option>
                <option value="0" >Inactive</option>
              @else
                <option value="1" >Active</option>
                <option value="0" selected>Inactive</option>
              @endif
          </select>
        </div>
        
        <button type="submit" name="update" class="btn btn-success float-end">
          Update  
        </button>
      </form>
    </div>
  </div>
@endsection