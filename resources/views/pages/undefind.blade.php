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
<div class="undefind">
	<div class="alert alert-danger" role="alert">
	  {{$message}}
	</div>
</div>
@endsection