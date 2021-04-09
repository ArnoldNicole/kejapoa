@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
	<div class="col-md-10">
		<div class="card">
			<div class="card-header bg-info">
				<h4>{{$house->house_name}}</h4>
			</div>
			<div class="card-body">
				<div class="container">
				    <div class="row">
				        <div class="col-3 p-3">
				            <img src="{{ $house->user->profile_image }}" class="rounded-circle w-100 img-fluid">
				            
				        </div>
				        <div class="col-9 pt-5">
				            <div class="d-flex justify-content-between align-items-baseline">
				                <div class="d-flex align-items-center pb-3">
				                	<h3>LandLord</h3>
				                    <div class="h4">{{ $house->user->name }}</div>

				                    {{-- <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"></follow-button> --}}
				                </div>	
				            </div>

				           <div class="btn-group pt-1">
				           	@auth
				           	<a href="/chat/contact_landlord/intent/{{$house->id}}" class="btn btn-success btn-sm">Contact Landlord</a>
				           	@else
				           	@if (Route::has('login'))
				           	 <a href="/login"  class="btn btn-outline-dark btn-sm">Login</a>				           	 
		
				           	@endif

				           	@if (Route::has('register'))
				           	 <a href="/register" title="Register to Contact Landlord" class="btn btn-outline-info btn-sm">Register to Contact {{$house->user->name}}</a>
				           	@endif
				           	
				           	@endauth
				           </div>
				                
				            

				           {{--  <div class="d-flex">
				                <div class="pr-5"><strong>50</strong> Comments</div>
				                <div class="pr-5"><strong>60</strong> Upvotes</div>
				                <div class="pr-5"><strong>78</strong> Interested</div>
				            </div> --}}
				            <div class="pt-2 font-weight-bold">Located at {{ $house->geo_location }}</div>
				            <div class="pt-2 font-weight-bold">Rooms : {{ $house->rooms }} </div>
				            <div class="pt-2 font-weight-bold">Rent Amount : {{ $house->rent_amount }} /= monthly</div>
				            <div class="pt-2 font-weight-bold">{{ $house->status }}</div>
				            <div>{!! $house->description !!}</div>
				            <div><a href="#">Landlord Kejapoa Profile</a></div>
				        </div>
				    </div>

				    <div class="row pt-5">
				        @foreach($house->images as $post)
				            <div class="col-4 pb-4">
				                <a href="/house/viewImage/{{ $post->id }}">
				                    <img src="{{$post->image}}" class="w-100">
				                </a>
				            </div>
				        @endforeach
				    </div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection