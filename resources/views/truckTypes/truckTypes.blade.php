@extends('layouts.dashboardLayout')

@section('title')
   Truck Types
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
   		<a href="/_admin/addPrice" class="add-driver-link btn btn-outline-primary" >Add Truck Type <i class="fas fa-plus"></i></a>
      <form action="/_admin/searchForTruckTypes" method="post">
        @csrf
        {{method_field("POST")}}
        <div class="search-form d-flex flex-nowrap justify-content-around align-items-center">
          <input type="text" autocomplete="off" class="form-control searchInput truckType" name="truckType" placeholder="Search By Name...">
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
          <th>Image</th>
          <th>Name</th>
          <th>Description</th>
          <th>Max Weight</th>
          <th>Area</th>
          <th>Activation</th>
          <th>Created At </th>
       </tr>
      </thead>
      <tbody>
        @foreach($truckTypes as $truck)
          <tr>
            <td class="align-middle"><a target="_blank" href="{{$truck->image}}"><img style="width: 100px ; height: 100px" src="{{$truck->image}}"></a></td>
            <td class="align-middle">{{$truck->name_en}}</td>
            <td class="align-middle">{{$truck->descriptions_en}}</td>
            <td class="align-middle">{{$truck->max_weight}}</td>
            <td class="align-middle">{{$truck->area}}</td>
            <td class="align-middle">{{($truck->is_active==1)?"Active":"Inactive"}}</td>
            <td class="align-middle">{{$truck->created_at}}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="d-flex justify-content-center">    
      {{ $truckTypes->links() }}
    </div>
@endsection









