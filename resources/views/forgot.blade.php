@extends("layouts.app")

@section("title", __("Forgot Password"))

@section("content")
<section id="auth-forgot" class="row justify-content-center">
	<div class="col-md-8 col-lg-4 align-self-center">
        <div class="card bg-authentication mb-0">
			<div class="row m-0">
				<div class="col-12 px-0">
                    <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
						<div class="card-header py-0">
                            <div class="card-title">
                                <h4 class="text-center mb-2">Forgot Password</h4>
                            </div>
                        </div>
						<div class="card-body">
							<form method="post" enctype="multipart/form-data">
								@csrf
								<div class="form-group mb-50">
									<label class="text-bold-600" for="logon">Please key in your username</label>
									<input type="text" class="form-control{{ $errors->has('logon') ? " is-invalid" : ""}}" id="logon" placeholder="{!! __("Username") !!}" name="logon" value="{{ old("logon") ? old("logon") : ""}}" />
									@if($errors->has('logon'))
									<div class="invalid-feedback">
										{{$errors->first("logon")}}
									</div>
									@endif
								</div>
								<div class="form-group">
									<div class="text-left"><a href="{{ route("login") }}" class="card-link"><small>Back to Login</small></a></div>
								</div>

								<button type="submit" class="btn btn-primary glow w-100 position-relative btn-block">Submit <i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@stop
