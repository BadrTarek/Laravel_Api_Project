@extends('layouts.dashboardLayout')

@section('title')
   {{$title}} 
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
   @if(session('error'))
   		<div class="alert alert-danger">      
          {{ session('error') }}
        </div>
   @endif
   <div class="content-header d-flex  flex-row-reverse align-items-center flex-wrap">
      <form action="/_admin/{{$search}}" method="post">
        @csrf
        {{method_field("POST")}}
        <div class="search-form d-flex flex-nowrap justify-content-around align-items-center">
          <input type="text" autocomplete="off" class="form-control adminName" name="adminName" placeholder="Search By Name...">
          <button class="btn btn-primary" name="search">Search</button>
        </div>

        <div class="row search-results">
          <div class="col-4 search-results-list">
            <div class="list-group">
              <!-- Search Results -->
            </div>
          </div>
       </div> 

      </form>
   </div>
   <table class="table ">
      <thead class="table-dark">
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Type</th>
          <th>Role</th>
          <th>Activation</th>
          <th>Edit</th>
       </tr>
      </thead>
      <tbody>
        @foreach($admins as $admin)
          <tr>  
            <td class="align-middle">{{$admin->name}}</td>
            <td class="align-middle">{{$admin->email}}</td>
            <td class="align-middle">{{$admin->phone}}</td>
            <td class="align-middle text-capitalize">{{$admin->type}}</td>
            <td class="align-middle text-capitalize">{{$admin->role}}</td>
            <td class="align-middle">{{($admin->is_active==1)?"Active":"Inactive"}}</td>
            <td class="align-middle"><a href="/_admin/editAdmin/{{$admin->id}}">Edit <i class="fas fa-edit"></i></a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="d-flex justify-content-center"> 
      {{$admins->links()}}
    </div>
@endsection









