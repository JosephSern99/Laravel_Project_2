@extends('layouts.app')
@section('title', 'Reset Password')

@section("content")
<div class="row justify-content-center">
	<div class="col-lg-6 align-self-center">
		<div class="card mb-3">
		  <div class="card-body">
				<h6>Reset Password</h6>
				<form id="fromSubmit" method="post" enctype="multipart/form-data" action="{{ URL::current() }}">
					@csrf
			  		<div class="form-row">
						<div class="form-group col-md-12 required">
							<label for="password" class="">Password</label>
							<input type="password" id="password" class="form-control{{ $errors->has('password') ? " is-invalid" : ""}}" name="password" value="" required />
							@if($errors->has('password'))
							<div class="invalid-feedback">
								{{ $errors->first("password") }}
							</div>
							@endif
						</div>

						<div class="form-group col-md-12 required">
							<label for="confirmpassword" class="">Confirm Password</label>
							<input type="password" id="confirmpassword" class="form-control{{ $errors->has('confirmpassword') ? " is-invalid" : ""}}" name="confirmpassword" value="" required />
							@if($errors->has('confirmpassword'))
							<div class="invalid-feedback">
								{{ $errors->first("confirmpassword") }}
							</div>
							@endif
						</div>

						<div class="col-12 justify-content-end">
							<div class="btn-group mr-2">

								<input type="submit" class="btn btn-primary glow w-100 position-relative btn-block" value="Save">
							</div>
						</div>

					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@stop
