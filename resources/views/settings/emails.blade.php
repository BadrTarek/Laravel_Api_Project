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
   <div class="content-header d-flex  justify-content-between align-items-center flex-wrap">
   		<a href="/_admin/addEmail" class="add-driver-link btn btn-outline-primary" >Add New Email <i class="fas fa-plus"></i></a>
      <form action="/_admin/searchForEmails" method="post">
        @csrf
        {{method_field("POST")}}
        <div class="search-form d-flex flex-nowrap justify-content-around align-items-center">
          <input type="text" autocomplete="off" class="form-control email" name="email" placeholder="Search By Email...">
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
          <th>Email</th>
          <th>Status</th>
          <th>Created At</th>
          <th colspan="2">Action</th>
       </tr>
      </thead>
      <tbody>
        @foreach($emails as $email)
          <tr>
            <td class="align-middle">{{$email->email}}</td>
            @if($email->is_active)
              <td class="align-middle">Active</td>              
            @else
              <td class="align-middle">Inactive</td>              
            @endif
            <td class="align-middle">{{$email->created_at}}</td>
            <td class="align-middle"><a class="btn btn-primary" href="/_admin/editEmail/{{$email->id}}"><i class="fas fa-edit"></i></td>
            <td class="align-middle">
              <form action="/_admin/deleteEmail/{{$email->id}}" method="post">
                @csrf
                <button class="btn btn-danger">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
@endsection









