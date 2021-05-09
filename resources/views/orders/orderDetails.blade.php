@extends('layouts.dashboardLayout')

@section('title')
   Order Details
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


   <table class="table align-middle">
      <tbody>
        <tr>
          <td>Code</td>
          <td>{{$order->code}}</td>
        </tr>
        <tr>
          <td>
            Image : 
          </td>
          <td>
            <a href="{{ $order->image }}" target="_blank"><img style="width: 200px;
            height: 200px;" src="{{ $order->image }}" ></a>
          </td>
        </tr>
        <tr>
          <td>
            Pickup Location: 
          </td>
          <td>
            <a target="_blank" href="http://maps.google.com/maps?saddr={{ $pickupLocation->latitude.','.$pickupLocation->longitude }}">Open in Google Map <i class="fas fa-map-marker-alt"></i></a>
          </td>
        </tr>
        <tr>
          <td>
            Pickup Location: 
          </td>
          <td>
            <a target="_blank" href="http://maps.google.com/maps?saddr={{ $destinationLocation->latitude.','.$destinationLocation->longitude }}">Open in Google Map <i class="fas fa-map-marker-alt"></i></a>
          </td>
        </tr>
        <tr>
          <td>
            Goods Types
          </td>
          <td>{{ $order->name_en }}</td>
        </tr>

        <tr>
          <td>
            Description
          </td>
          <td>{{ ($order->description==null)?"Undefind":$order->description }}</td>
        </tr>
        

        @if($order->phone !=null)
          <tr>
            <td>
              Country Code
            </td>
            <td>{{ $order->country_code }}</td>
          </tr>
          <tr>
            <td>
              Phone
            </td>
            <td>{{ $order->phone }}</td>
          </tr>
        @endif
        
        <tr>
          <td>
            Load Weight
          </td>
          <td>{{ ($order->load_weight==null)?"Unknown":$order->load_weight }}</td>
        </tr>

         <tr>
          <td>
            Status
          </td>
          <td>{{ orderStatus($order->status) }}</td>
         </tr>

         <tr>
          <td>
            Created At 
          </td>
          <td>{{ orderStatus($order->created_at) }}</td>
         </tr>

         <tr>
          <td>
            User Name 
          </td>
          <td><a target="_blank"class="text-decoration-none" href="/_admin/viewUser/{{$order->order_user['id']}}">{{$order->order_user["name"]}}</a></td>
         </tr>

         <tr>
          <td>
            Driver Name 
          </td>
          <td><a target="_blank"class="text-decoration-none" href="/_admin/editDriver/{{$order->order_driver['id']}}">{{ $order->order_driver["name"] }}</a></td>
         </tr>
        
        
      </tbody>
    </table>

@endsection









