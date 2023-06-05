@extends("layouts.app")

@section("header")
<title>{{ __("Reset Password") }}</title>
@stop

@section("content")

<section id="auth-forgot" class="row justify-content-center">
	<div class="col-md-8 col-lg-4 align-self-center">
        <div class="card bg-authentication mb-0">
			<div class="row m-0">
				<div class="col-12 px-0">
                    <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
						<div class="card-header py-0">
                            <div class="card-title">
                                <h4 class="text-center mb-2">Password Reset.</h4>
                            </div>
                        </div>
						<div class="card-body">
							@if($status == "fail")
							<div>Fail to reset password. You had no registered email.</div>
							<div>Click <a href="{{ route("login") }}">here</a> to login.</div>
							@else
							<div>Your password had been reset, and an email had sent to your email: <code>{{ $email }}</code>.</div>
							<div>Please check your email.</div>
							<div>Click <a href="{{ route("login") }}">here</a> to login.</div>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@stop
