@extends('layouts.app')
@section('content')
<div class="col-md-12 my-auto" id="app">
	
	<chat-area :sender='{{ json_encode($sender) }}' :recipient='{{ json_encode($recipient) }}'>
		
	</chat-area>
</div>
@endsection
