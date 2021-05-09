@extends('layouts.dashboardLayout')

@section('title')
   View Message
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
          <td>{{$contact->code}}</td>
        </tr>

        <tr>
          <td>Status </td>
          <td>{{ $contact->status }}</td>
        </tr>

        <tr>
          <td>Type</td>
          <td>
            @if($contact->users_id != null)
              User
            @elseif($contact->drivers_id != null)
              Driver
            @else
              Guest
            @endif
          </td>
        </tr>

        <tr>
          <td>Name</td>
          <td>
             @if($contact->users_id != null)
                <a class="text-decoration-none" target="_blank" href="/_admin/viewUser/{{$contact->users_id}}">{{$contact->users_name}}</a>
              @elseif($contact->drivers_id != null)
                <a class="text-decoration-none" target="_blank" href="/_admin/editDriver/{{$contact->drivers_id}}">{{$contact->drivers_name}}</a>
              @else
                In Message
              @endif
          </td>
        </tr>

        <tr>
          <td>Phone</td>
          <td>
             @if($contact->users_id != null)
                {{$contact->users_phone}}
              @elseif($contact->drivers_id != null)
                {{$contact->drivers_phone}}
              @else
                In Message
              @endif
          </td>
        </tr>

        <tr>
          <td>Contact Type</td>
          <td>{{ $contact->name_en }}</td>
        </tr>

        <tr>
          <td>Message </td>
          <td>{{ $contact->message }}</td>
        </tr>

        



        
        
        
      </tbody>
    </table>

@endsection









