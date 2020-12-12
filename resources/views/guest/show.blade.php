@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-8">
            <img src="{{$image->image }}" class="w-100">
        </div>
        <div class="col-4">
            <div>
                <div class="d-flex align-items-center">
                    <div class="pr-3">
                        <img src="{{ $image->house->user->profile_image }}" class="rounded-circle w-100" style="max-width: 40px;">
                    </div>
                    <div>
                        <div class="font-weight-bold">
                            <a href="/house/profile/{{$image->house->id}}">
                                <span class="text-dark">{{$image->house->house_name}}</span>
                            </a>                            
                        </div>
                    </div>
                </div>

                <hr>

                <p>
                    <span class="font-weight-bold">
                        {{-- <a href="/profile/{{ $image->user->id }}">
                            <span class="text-dark">{{ $image->user->username }}</span>
                        </a> --}}
                    </span> 
                    <br>
                    <p class="font-weight-bold text-white">{{ $image->caption }}</p>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection