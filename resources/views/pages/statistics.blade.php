@extends('layouts.dashboardLayout')

@section('title')
   Statistics
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
   <div class="dashboard-cards-cotainer d-flex justify-content-center flex-wrap">
       <div class="box">
         <div class="box-icon d-flex justify-content-center align-items-center">
           <i class="fas fa-money-bill-alt"></i>
         </div>
         <div class="box-title d-flex justify-content-center align-items-end">
           Revenue
         </div>
         <div class="box-value d-flex justify-content-center align-items-center">
           {{$totalPays}}
         </div>
       </div>

       <div class="box">
         <div class="box-icon d-flex justify-content-center align-items-center">
           <i class="fas fa-user-tag"></i>
         </div>
         <div class="box-title d-flex justify-content-center align-items-end">
           All Conatacts
         </div>
         <div class="box-value d-flex justify-content-center align-items-center">
           {{$number_of_messages}}
         </div>
       </div>

       <div class="box">
         <div class="box-icon d-flex justify-content-center align-items-center">
           <i class="fas fa-user-tag"></i>
         </div>
         <div class="box-title d-flex justify-content-center align-items-end">
           Users Conatacts
         </div>
         <div class="box-value d-flex justify-content-center align-items-center">
           {{$number_of_users_messages}}
         </div>
       </div>

       <div class="box">
         <div class="box-icon d-flex justify-content-center align-items-center">
           <i class="fas fa-user-tag"></i>
         </div>
         <div class="box-title d-flex justify-content-center align-items-end">
           Drivers Conatacts
         </div>
         <div class="box-value d-flex justify-content-center align-items-center">
           {{$number_of_drivers_messages}}
         </div>
       </div>


       <div class="box">
         <div class="box-icon d-flex justify-content-center align-items-center">
           <i class="fas fa-shopping-cart"></i>
         </div>
         <div class="box-title d-flex justify-content-center align-items-end">
           Orders
         </div>
         <div class="box-value d-flex justify-content-center align-items-center">
           {{$number_of_orders}}
         </div>
       </div>


       <div class="box">
         <div class="box-icon d-flex justify-content-center align-items-center">
           <i class="fas fa-truck-loading"></i>
         </div>
         <div class="box-title d-flex justify-content-center align-items-end">
           Goods Types
         </div>
         <div class="box-value d-flex justify-content-center align-items-center">
           {{$good_types}}
         </div>
       </div>
       
       <div class="box">
         <div class="box-icon d-flex justify-content-center align-items-center">
           <i class="fas fa-truck-moving"></i>
         </div>
         <div class="box-title d-flex justify-content-center align-items-end">
           Trucks Types
         </div>
         <div class="box-value d-flex justify-content-center align-items-center">
           {{$truck_types}}
         </div>
       </div>


       <div class="box">
         <div class="box-icon d-flex justify-content-center align-items-center">
           <i class="fas fa-envelope"></i>
         </div>
         <div class="box-title d-flex justify-content-center align-items-end">
           E-mail Subscribers
         </div>
         <div class="box-value d-flex justify-content-center align-items-center">
           15
         </div>
       </div>
      <div class="box">
         <div class="box-icon d-flex justify-content-center align-items-center">
           <i class="fas fa-users"></i>
         </div>
         <div class="box-title d-flex justify-content-center align-items-end">
           Users
         </div>
         <div class="box-value d-flex justify-content-center align-items-center">
           {{$number_of_users}}
         </div>
       </div>

       <div class="box">
         <div class="box-icon d-flex justify-content-center align-items-center">
           <i class="fas fa-users"></i>
         </div>
         <div class="box-title d-flex justify-content-center align-items-end">
           Drivers
         </div>
         <div class="box-value d-flex justify-content-center align-items-center">
           {{$number_of_drivers}}
         </div>
       </div>

       <div class="box">
         <div class="box-icon d-flex justify-content-center align-items-center">
           <i class="fas fa-users-cog"></i>
         </div>
         <div class="box-title d-flex justify-content-center align-items-end">
           Companies
         </div>
         <div class="box-value d-flex justify-content-center align-items-center">
           {{$number_of_companies}}
         </div>
       </div>

       <div class="box">
         <div class="box-icon d-flex justify-content-center align-items-center">
           <i class="fas fa-users"></i>
         </div>
         <div class="box-title d-flex justify-content-center align-items-end">
           Admins
         </div>
         <div class="box-value d-flex justify-content-center align-items-center">
           {{$number_of_admins}}
         </div>
       </div>


     </div>


@endsection









