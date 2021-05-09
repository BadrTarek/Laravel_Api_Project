@extends('layouts.dashboardLayout')

@section('title')
   Price List
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
   		<a href="/_admin/addPrice" class="add-driver-link btn btn-outline-primary" >Add New Price <i class="fas fa-plus"></i></a>
   </div>
   <table class="table ">
      <thead class="table-dark">
        <tr>
          <th>Distance</th>
          <th>Price</th>
          <th>Truck</th>
          <th>Edit</th>
       </tr>
      </thead>
      <tbody>
        @foreach($priceList as $price)
          <tr>
            <td class="align-middle">{{$price->category}}</td>
            <td class="align-middle">{{$price->price}}</td>
            <td class="align-middle">{{$price->trucks_types_name}}</td>
            <td class="align-middle"><a href="/_admin/editPrice/{{ $price->id }}">Edit <i class="fas fa-edit"></i></a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
@endsection









