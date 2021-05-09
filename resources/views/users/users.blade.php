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
   <div class="content-header d-flex  flex-row-reverse align-items-center ">
	    <form action="/_admin/searchForUsers" class="float-end" method="post">
        @csrf
        {{method_field("POST")}}
	   	  <div class="search-form d-flex flex-nowrap justify-content-around align-items-center">
	   	  	<input type="text" autocomplete="off" class="form-control userName" name="userName" placeholder="Search By Name..">
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
          <th>User Name</th>
          <th>Phone</th>
          <th>Activation</th>
          <th>Language</th>
          <th>Created At</th>
          <th>Action</th>
          <th>View</th>
          <th>Number Of Orders</th>
       </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
          <tr>
            <td class="align-middle">{{$user->name}}</td>
            <td class="align-middle">{{$user->phone}}</td>
           <td class="align-middle">
              @if($user->is_active == 1 )
                Acitve
              @else
                Inactive
              @endif
            </td> 
      	   	<td class="align-middle">{{( $user->language=='en')?"English":"Arabic"}}</td>
            <td class="align-middle">{{$user->created_at}}</td>
            <td class="align-middle">
              @if($user->is_active == 1)
                <form method="post" action="/_admin/inactiveUser/{{ $user->id }}">
                  @csrf
                  <button class="btn btn-secondary">
                    Inactive
                  </button>
                </form>
              @else
                <form method="post" action="/_admin/activeUser/{{ $user->id }}">
                  @csrf
                  <button class="btn btn-success">
                    Active
                  </button>
                </form>
              @endif
            </td>
            <td class="align-middle"><a href="/_admin/viewUser/{{$user->id}}">View</a></td>
            <td class="align-middle text-center">{{ $user->number_of_orders}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="d-flex justify-content-center">    
    	{{ $users->links() }}
  	</div>
@endsection









