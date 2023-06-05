@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ URL::asset('css/Apro.css?v=1.0.0') }}">


<div class="LoginPage">
    <div class="row justify-content-center"><a href="{{ url('/') }}"><img alt="Logo" class="apro-logo" src="{{ asset('logo/apro1.png?v=1.0.0') }}"></a></div>
    <div class="Apro-Technology-Pte-Ltd">
		Apro Technology Pte Ltd
	</div>

    <div class="Login">
		{{ __('Login') }}
	</div>

    <div class="Enter-your-username-and-password-below">
		Enter your username and password below
	</div>


    <form method="POST" action="{{ route('login') }}">
		@csrf
		<label class="labelusername">
			USERNAME
		</label>

        <div class="textarea-bg-username">
            <input style="width:100%;" id="User_Logon" type="text" class="form-control @error('User_Logon') is-invalid @enderror textfield-username" name="User_Logon" value="{{ old('User_Logon') }}" required autocomplete="username" autofocus>

            @error('User_Logon')
            @if($errors->has('User_Logon'))
                <script type="text/javascript" src="{{ URL::asset('js/login.js?v=1.1.2') }}"></script>
                <div class="sheet" role="dialog">

                    <button  type="button"  class="close" id="close"><img class="close" alt="close" src="{{ asset('icon/close.svg?v=1.0.0') }}"></button>
                    <div class="Error">Error</div>
                    <div class="wuap">Wrong username and/or password</div>
                    <button  type="button"  class="buttonok" id="buttonok">Ok</button>
                </div>
            @endif
            @enderror
        </div>


        <div style="justify-content: space-between; flex-wrap: wrap;
    justify-content: space-between;
    display: flex;">
			<div class="labelpassword">PASSWORD</div>
			<div class="Forgot-password" style="margin-top:10px;">
                <a href="{{ route("forgot")}}" style="color: #9fa2b4;">Forgot Password?</a>
			</div>
		</div>


        <div class="textarea-bg-username">


            <div style="justify-content: space-between;
        justify-content: space-between;
        display: flex;">
            <input style="width:100%;" id="password" type="password"  class="form-control @error('password') is-invalid @enderror textfield-username" name="password" required autocomplete="current-password">




            <button id="hideorshow" style="background-color: transparent; background-repeat: no-repeat;
                border: none;
                cursor: pointer;
                overflow: hidden;
                outline: none;
                margin-top: -3px;
                "  onclick="showorhide()" type="button">
                <img class="img-logo  text-center" id="eye" alt="Logo" src="{{ asset('icon/Vector.png?v=1.0.0') }}"></a>
            </button>
            </div>

            @error('password')
            @if($errors->has('password'))
            <script type="text/javascript" src="{{ URL::asset('js/login.js?v=1.1.2') }}"></script>
            <div class="sheet" role="dialog">
                <button  type="button"  class="close" id="close"><img class="close" alt="close" src="{{ asset('icon/close.svg?v=1.0.0') }}"></button>
                <div class="Error mt-3">Error</div>
                <div class="wuap">Wrong username and/or password</div>
                <button  type="button"  class="buttonok" id="buttonok">Ok</button>
            </div>
            @endif
            @enderror



        </div>

        <button type="submit" class="btn-bg-login">

            Login

        </button>

    </form>



    <div class="Copyright-Apro-Technology-Pte-Ltd-2023-V100 container"> Copyright © Apro Technology Pte Ltd 2023 </div>
</div>

@endsection
@section('script')
<script>

$("#close").on("click", function(){
    $("#User_Logon").removeAttr('disabled');
    $(".textfield-password").removeAttr('disabled');
    $("div.sheet").remove();
    $(".LoginPage").css("background-color","#fff");
    $("body").css("background-color","#fff");

});

$("#buttonok").on("click", function(){
    $("#User_Logon").removeAttr('disabled');
    $(".textfield-password").removeAttr('disabled');
    $("div.sheet").remove();
    $(".LoginPage").css("background-color","#fff");
    $("body").css("background-color","#fff");
});

function showorhide(){
  var x = document.getElementById("password");
  if (x.type === "password") {
    $("img#eye").attr("src", "{{ asset('icon/show-password.svg?v=1.0.0') }}" );
    x.type = "text";

  } else {
    $("img#eye").attr("src", "{{ asset('icon/Vector.png?v=1.0.0') }}" );
    x.type = "password";

  }
}



</script>


@endsection
