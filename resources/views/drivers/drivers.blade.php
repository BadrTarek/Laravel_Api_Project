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
      @if(auth("admin")->user()->type == "admin")
   		   <a href="/_admin/addDriver" class="add-driver-link btn btn-outline-primary" >Add Driver <i class="fas fa-plus"></i></a>
        <form action="/_admin/searchForDrivers" method="post">
      @else
         <a href="/_company/addDriver" class="add-driver-link btn btn-outline-primary" >Add Driver <i class="fas fa-plus"></i></a>
        <form action="/_company/searchForDrivers" method="post">
      @endif
        @csrf
        {{method_field("POST")}}
	   	  <div class="search-form d-flex flex-nowrap justify-content-around align-items-center">
	   	  	<input type="text" autocomplete="off" class="form-control driverName" name="driverName" placeholder="Search By Name..">
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
          <th>Driver Name</th>
          <th>Phone</th>
          <th>Activation</th>
          <th>Language</th>
          <th>Created At</th>
          <th>Action</th>
          <th>Location</th>
       </tr>
      </thead>
      <tbody>
        @foreach($drivers as $driver)
          <tr>
            <td class="align-middle">{{$driver->name}}</td>
            <td class="align-middle">{{$driver->phone}}</td>
           <td>
              @if($driver->is_active == 1 )
                Acitve
              @else
                Inactive
              @endif
            </td> 
      	   	<td class="align-middle">{{( $driver->language=='en')?"English":"Arabic"}}</td>
            <td class="align-middle">{{$driver->created_at}}</td>
            @if(auth("admin")->user()->type == "admin")
              <td class="align-middle"><a href="/_admin/editDriver/{{ $driver->id }}">Edit <i class="fas fa-edit"></i></a></td>
            @else
              <td class="align-middle"><a href="/_company/editDriver/{{ $driver->id }}">Edit <i class="fas fa-edit"></i></a></td>
              @endif
            @if($driver->locations_id != null)
            {{$driver->latitude}}
              <td class="align-middle"><a target="_blank" href="http://maps.google.com/maps?saddr={{ $driver->latitude.','.$driver->longitude }}">Open in Google Map <i class="fas fa-map-marker-alt"></i></a></td>
            }
            }
            @else
              <td class="align-middle">Undefind</td>
            @endif
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="d-flex justify-content-center">    
    	{{ $drivers->links() }}
  	</div>
@endsection









