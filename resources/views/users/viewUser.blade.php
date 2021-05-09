@extends('layouts.dashboardLayout')

@section('title')
   View User
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
          <td>
            User Image : 
          </td>
          <td>
            <a href="{{ $user->image }}" target="_blank"><img style="width: 200px;
            height: 200px;" src="{{ $user->image }}" ></a>
          </td>
        </tr>
        <tr>
          <td>
            User Name : 
          </td>
          <td>
            {{ $user->name }}
          </td>
        </tr>
        <tr>
          <td>
            User Email : 
          </td>
          <td>
            {{ ($user->email==null)?"undefind":$user->email }}
          </td>
        </tr>
        <tr>
          <td>
            User Phone : 
          </td>
          <td>
            {{ $user->phone }}
          </td>
        </tr>

        <tr>
          <td>
            Country Code : 
          </td>
          <td>
            {{ $user->country_code }}
          </td>
        </tr>

        <tr>
          <td>
            Language : 
          </td>
          <td>
            {{ ( $user->language=="en")?"English":"Arabic"  }}
          </td>
        </tr>

        <tr>
          <td>
            Number Of Orders : 
          </td>
          <td>
            {{  $user->number_of_orders  }}
          </td>
        </tr>
         <tr>
          <td>
            Activation
          </td>
            <td>
              @if($user->is_active == 1 )
                <form action="/_admin/inactiveUser/{{ $user->id }}" method="post">
                  @csrf
                  <button class="btn btn-secondary">
                    Inactive
                  </button>
                </form>
              @else
                <form action="/_admin/activeUser/{{ $user->id }}" method="post">
                  @csrf
                  <button class="btn btn-success">
                    Active
                  </button>
                </form>
              @endif
           </td>
         </tr>
         <tr>
           <td>Language</td>
           <td>{{( $user->language=='en')?"English":"Arabic"}}</td>
         </tr>
        <tr>
          <td>
            Created At : 
          </td>
          <td>
            {{$user->created_at }}
          </td>
        </tr>
      </tbody>
    </table>

@endsection









