@extends('layouts.app')
@section('content')

  <header class="masthead container">

     
          
          	<h4 class='text-center text-capitalize'>fill this form to contact us</h4>
          	<hr>
          	<div class="row justify-content-center">
          		    <div class="col">
          		    	<form method="post" action="">
          			@csrf

          				<div class="row form form-group">

          					<div class="col-6">
          						<div class="row form-group">
          				<label class="text-md-right col-form-label col-md-4 font-weight-bold" for="FirstName">Enter first name</label>

          				<div class="input-group col-md-8">
          					<input type="text" name="FirstName" value="{{old('FirstName')}}" class="form-control">
          				</div>

          			</div>
          					</div>
          					<div class="col-6">
          						<div class="row form-group">
          				<label class="text-md-right col-form-label col-md-4 font-weight-bold" for="lastName">Enter last name</label>

          				<div class="input-group col-md-8">
          					<input type="text" name="lastName" value="{{old('lastName')}}" class="form-control">
          				</div>

          			</div>
          					</div>			
          				
          				</div>

          			

          			

          			<div class="row form-group">
          				<label class="text-md-right col-form-label col-md-4 font-weight-bold" for="email">Enter email</label>

          				<div class="input-group col-md-8">
          					<input type="email" name="email" value="{{old('email')}}" class="form-control">
          				</div>

          			</div>

          			<div class="row form-group">
          				<label class="text-md-right col-form-label col-md-4 font-weight-bold" for="email">type your message here</label>

          				<div class="input-group col-md-8">
          					<textarea name="email"  class="form-control" rows="5">
          					{{old('email')}}
          					</textarea>
          				</div>

          			</div>

          			<div class="row form-group justify-content-center">
          				

          				<div class="input-group col-md-8">
          					<button class="btn btn-block btn-success">send message</button>
          				</div>

          			</div>


          		</form>
          		    </div>		
          	</div>
          
  

</header>










@endsection
