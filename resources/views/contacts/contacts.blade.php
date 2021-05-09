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
      <form action="/_admin/searchForContacts" method="post">
        @csrf
        {{method_field("POST")}}
        <div class="search-form d-flex flex-nowrap justify-content-around align-items-center">
          <input type="text" autocomplete="off" class="form-control contactCode" name="contactCode" placeholder="Search By Code...">
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
          <th>Type</th>
          <th>Name</th>
          <th>Phone</th>
          <th>Code</th>
          <th>Contact Type</th>
          <th>View Message</th>
       </tr>
      </thead>
      <tbody>
        @foreach($contacts as $contact)
          <tr>
            <td class="align-middle">
              @if($contact->users_id != null)
                User
              @elseif($contact->drivers_id != null)
                Driver
              @else
                Guest
              @endif
            </td>
            <td class="align-middle">
              @if($contact->users_id != null)
                <a target="_blank" class="text-decoration-none"href="/_admin/viewUser/{{$contact->users_id}}">
                  {{$contact->users_name}}
                </a>
              @elseif($contact->drivers_id != null)
                <a target="_blank" class="text-decoration-none"href="/_admin/editDriver/{{$contact->drivers_id}}">
                  {{$contact->drivers_name}}
                </a>
              @else
                In Message
              @endif
            </td>
            <td class="align-middle">
              @if($contact->users_id != null)
                {{$contact->users_phone}}
              @elseif($contact->drivers_id != null)
                {{$contact->drivers_phone}}
              @else
                In Message
              @endif
            </td>
            <td class="align-middle">
              {{$contact->code}}
            </td>
            <td class="align-middle">
              {{$contact->name_en}}
            </td>
            <td class="align-middle">
              <a href="/_admin/viewContact/{{$contact->id}}">View Message</a>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <div class="d-flex justify-content-center"> 
      {{$contacts->links()}}
    </div>
@endsection









