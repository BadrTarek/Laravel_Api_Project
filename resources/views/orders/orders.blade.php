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
	    <form action="/_admin/ordersWithFilter" method="post">
        @csrf
        <div class="search-form d-flex flex-nowrap justify-content-around align-items-center">
          <select class="form-select" id="formGroupExampleInput" required name="status" aria-label="Default select example">
            <option disabled value="" selected>Choose Status...</option>
            @foreach(allOrdersStatus()  as $status)
              <option value="{{orderStatusInDB($status)}}">{{$status}}</option>
            @endforeach
          </select>
	   	  	<button class="btn btn-primary" name="search">Filter</button>
	   	  </div>

	    </form>

      <form action="/_admin/searchForOrders" method="post">
        @csrf
        {{method_field("POST")}}
        <div class="search-form d-flex flex-nowrap justify-content-around align-items-center">
          <input type="text" autocomplete="off" class="form-control orderCode" name="orderCode" placeholder="Search By Code..">
          <button class="btn btn-primary" name="search">Search</button>
        </div>

        <div class="row search-results">
          <div class="col-4 search-results-list">
            <div class="list-group">
            </div>
          </div>
       </div> 
      </form>
   </div>
   <table class="table ">
      <thead class="table-dark">
        <tr>
          <th>Code</th>
          <th>Image</th>
          <!-- <th>Pickup Location</th>
          <th>Destination Location</th> -->
          <th>Load Weight</th>
          <th>Status</th>
          <th>Driver Name</th>
          <th>User Name</th>
          <th>Order Details</th>
       </tr>
      </thead>
      <tbody>
        @foreach($orders as $order)
          <tr>
            <td class="align-middle">{{ $order->code }}</td>
            <td class="align-middle"><a target="_blank" href="{{$order->image}}"><img style="width: 100px ; height: 100px" src="{{$order->image}}"></a></td>
             <!-- <td class="align-middle"><a target="_blank" href="http://maps.google.com/maps?saddr=1.1,3.0">Open in Google Map <i class="fas fa-map-marker-alt"></i></a></td>
             <td class="align-middle"><a target="_blank" href="http://maps.google.com/maps?saddr=1.1,3.0">Open in Google Map <i class="fas fa-map-marker-alt"></i></a></td> -->
            <td class="align-middle">{{$order->load_weight}}</td>
            <td class="align-middle">{{orderStatus($order->status)}}</td>
            <td class="align-middle"><a target="_blank"class="text-decoration-none" href="/_admin/editDriver/{{$order->order_driver['id']}}">{{$order->order_driver["name"]}}</a></td>
            <td class="align-middle"><a target="_blank"class="text-decoration-none" href="/_admin/viewUser/{{$order->order_user['id']}}">{{$order->order_user["name"]}}</a></td>
            <td class="align-middle"><a href="/_admin/orderDetails/{{$order->id}}">Order Details</a></td>
         </tr>
        @endforeach
      </tbody>
    </table>
    <div class="d-flex justify-content-center">    
    	{{ $orders->links() }}
  	</div>
@endsection









