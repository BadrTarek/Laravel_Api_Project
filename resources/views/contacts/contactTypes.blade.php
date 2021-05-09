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
   		<a href="/_admin/addContactType" class="add-driver-link btn btn-outline-primary" >Add New Contact Type <i class="fas fa-plus"></i></a>
      <form action="/_admin/searchForContactTypes" method="post">
        @csrf
        {{method_field("POST")}}
        <div class="search-form d-flex flex-nowrap justify-content-around align-items-center">
          <input type="text" autocomplete="off" class="form-control contactType" name="contactType" placeholder="Search By Name..">
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
          <th>Edit</th>
       </tr>
      </thead>
      <tbody>
        @foreach($contactTypes as $type)
          <tr>
            <td class="align-middle">{{$type->name_en}}</td>
            <td class="align-middle"><a href="/_admin/editContactType/{{ $type->id }}">Edit <i class="fas fa-edit"></i></a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
@endsection









