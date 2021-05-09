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
   		<a href="/_admin/addPhone" class="add-driver-link btn btn-outline-primary" >Add New Phone <i class="fas fa-plus"></i></a>
      <form action="/_admin/searchForPhones" method="post">
        @csrf
        {{method_field("POST")}}
        <div class="search-form d-flex flex-nowrap justify-content-around align-items-center">
          <input type="text" autocomplete="off" class="form-control phone" name="phone" placeholder="Search By Phone...">
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
          <th>Phone</th>
          <th>Status</th>
          <th>Created At</th>
          <th colspan="2">Action</th>
       </tr>
      </thead>
      <tbody>
        @foreach($phones as $phone)
          <tr>
            <td class="align-middle">{{$phone->phone}}</td>
            @if($phone->is_active)
              <td class="align-middle">Active</td>              
            @else
              <td class="align-middle">Inactive</td>              
            @endif
            <td class="align-middle">{{$phone->created_at}}</td>
            <td class="align-middle"><a class="btn btn-primary" href="/_admin/editPhone/{{$phone->id}}"><i class="fas fa-edit"></i></td>
            <td class="align-middle">
              <form action="/_admin/deletePhone/{{$phone->id}}" method="post">
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









