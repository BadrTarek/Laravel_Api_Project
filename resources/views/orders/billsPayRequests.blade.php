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
      <form action="/_admin/searchForBillPayRequests" method="post">
        @csrf
        {{method_field("POST")}}
        <div class="search-form d-flex flex-nowrap justify-content-around align-items-center">
          <input type="text" autocomplete="off" class="form-control requestCode" name="requestCode" placeholder="Search By Code...">
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
          <th>Image</th>
          <th>User Name</th>
          <th>Price</th>
          <th>Discount</th>
          <th>Status</th>
          <th>Request Code</th>
          <th>Created At</th>
          <th>Action</th>
          <th>Order Details</th>
       </tr>
      </thead>
      <tbody>
        @foreach($requests as $request)
          <tr>
            <td class="align-middle"><a target="_blank" href="{{$request->image_deposit}}"><img style="width: 100px ; height: 100px" src="{{$request->image_deposit}}"></a></td>
            <td class="align-middle"><a class="text-decoration-none" href="/_admin/viewUser/{{$request->users_id}}">{{ $request->name }}</a></td>
            <td class="align-middle">{{ $request->cost }}</td>
            <td class="align-middle">{{ ($request->discount==null)?"Undefind":$request->discount."%" }}</td>
            <td class="align-middle">{{ ($request->admin_approve==0||$request->admin_approve==null)?"Wating For Accept":"Accepted" }}</td>
            <td class="align-middle">{{ $request->code }}</td>
            <td class="align-middle">{{ $request->created_at }}</td>
            <td class="align-middle">
              @if($request->admin_approve==1)
                ---------
              @else
                <form action="/_admin/acceptBillPayRequest/{{ $request->id }}" method="post">
                  @csrf
                  <button class="btn btn-success">Accept</button>
                </form>
              @endif
            </td>
            <td class="align-middle"><a href="/_admin/orderDetails/{{$request->orders_id}}">Order Details</a></td>
         </tr>
        @endforeach
      </tbody>
    </table>
    <div class="d-flex justify-content-center">    
    	{{ $requests->links() }}
  	</div>
@endsection









