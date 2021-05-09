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
      <a href="/_admin/addDiscountCode" class="add-driver-link btn btn-outline-primary" >Add New Discount Code <i class="fas fa-plus"></i></a>
      <form action="/_admin/searchForDiscountCodes" method="post">
        @csrf
        {{method_field("POST")}}
        <div class="search-form d-flex flex-nowrap justify-content-around align-items-center">
          <input type="text" autocomplete="off" class="form-control discountCode" name="discountCode" placeholder="Search By Code...">
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
          <th>Code</th>
          <th>Discount Percentage</th>
          <th>Count</th>
          <th>Start Date</th>
          <th>End Date </th>
          <th>Activation</th>
          <th colspan="2">Action</th>
       </tr>
      </thead>
      <tbody>
        @foreach($codes as $code)
          <tr>
            <td class="align-middle">
              {{$code->code}}
            </td>
            <td class="align-middle">
              {{$code->discount}}%
            </td>
            <td class="align-middle">
              {{$code->count}}
            </td>
            <td class="align-middle">
              {{$code->created_at}}
            </td>
            <td class="align-middle">
              {{$code->end_date}}
            </td>
            <td class="align-middle">
              @if($code->is_active == 0)
                Inactive
              @else
                Active
              @endif
            </td>
            <td class="align-middle">
              @if($code->is_active == 0)
                <form action="/_admin/activeDiscountCode/{{$code->id}}" method="post">
                    @csrf
                    <button class="btn btn-success">
                      Active
                    </button>
                </form>
              @else
                @if($code->count == 0)
                  --------
                @else
                  <form action="/_admin/deactivateDiscountCode/{{$code->id}}" method="post">
                      @csrf
                      <button class="btn btn-secondary">
                        InActive
                      </button>
                  </form>
                @endif
              @endif
            </td>
            <td class="align-middle">
              <form action="/_admin/deleteDiscountCode/{{$code->id}}" method="post">
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
    <div class="d-flex justify-content-center"> 
      {{$codes->links()}}
    </div>
@endsection









