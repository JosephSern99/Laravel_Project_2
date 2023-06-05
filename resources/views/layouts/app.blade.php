<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>@yield("title")</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js?v=1.0.0') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css?v=1.0.1') }}" rel="stylesheet">
    <link href="{{ asset('css/Apro.css?v=1.0.4') }}" rel="stylesheet">

    <link href="{{ asset('fontawesome/css/all.min.css?v=5.15.1') }}" rel="stylesheet">
    <link href="{{ asset("bootstrap-datetimepicker/eonasdan-bootstrap-datetimepicker.css?v=4.17.48") }}" rel="stylesheet">
    <!-- <link rel="stylesheet" type="text/css" href="{!! url("datatables/dataTables.bootstrap4.css") !!}"> -->
	<!-- <link rel="stylesheet" type="text/css" href="{!! url("datatables/responsive.dataTables.min.css") !!}"> -->
	<link href="{{ asset('css/main.css?v=1.1.0') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{!! url("fresh/app-assets/vendors/css/file-uploaders/dropzone.min.css") !!}">
    <link rel="stylesheet" href="{{ URL::asset('css/layout.css?v=1.0.0') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('logo/apro1.png?v=1.0.0') }}">
    <link rel="stylesheet" type="text/css" href="{!! url("fresh/app-assets/css/bootstrap.css") !!}">
    <link rel="stylesheet" type="text/css" href="{!! url("fresh/app-assets/css/bootstrap-extended.css") !!}">
    <link rel="stylesheet" type="text/css" href="{!! url("fresh/app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css") !!}">
    <link rel="stylesheet" type="text/css" href="{!! url("fresh/app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css") !!}">
    <link rel="stylesheet" type="text/css" href="{!! url("fresh/app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css") !!}">
    <link rel="stylesheet" type="text/css" href="{!! url("vendor/bootstrap-select/css/bootstrap-select.css?v=v1.13.1") !!}">
    <link rel="stylesheet" type="text/css" href="{!! url("boxicons-2.1.4/css/boxicons.min.css?v=2.1.4") !!}">

    @yield("css")
</head>
<body class="bg-white">
    <div id="app" class="actualdivapp">
            @guest
            @else
            <div class="container row justify-content-left">
                <div class="Menu"><a href="{!!route("cs.index")!!}"><img src="{{ asset('icon/menu.svg?v=1.0.0') }}"></a></div>

                <div class="title">
                    @yield('title')
                </div>
            </div>
            <!-- <span class="SearchBar-OnMenu"><a href=""><img alt="Search" src="{{ asset('icon/search.svg?v=1.0.0') }}"></a></span> -->
            <div class="float-right">
                <div class="home-btn"><a href="{!!route("cs.index")!!}"><img alt="Logo" src="{{ asset('icon/home.svg?v=1.0.0') }}"></a></div>
                <div class="photo"><a style="font-family: 'Mulish';" href="#" data-toggle="modal" data-target="#logoutModal">{{ auth()->user()->User_FirstName }}</a></div>
            </div>
            @endguest
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="LogoutModalTitle" aria-hidden="true" style="font-family: 'Mulish' !important;">
        <div class="modal-dialog" role="document" style="font-family: 'Mulish' !important;">
        <div class="modal-content border-0" style="font-family: 'Mulish' !important;">
            <div class="modal-header">
                <h6 class="modal-title" id="LogoutModalTitle" style="font-family: 'Mulish' !important;">{!! __('label.logout_modal.title') !!}</h6>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <!-- <div class="modal-body" style="font-family: 'Mulish' !important;">{!! __('message.logoutconfirmation') !!}</div> -->
            <div class="modal-footer justify-content-center">
                <form action="{!! route('logout') !!}" method="post">
                @csrf
                <button class="btn btn-teal" type="button" data-dismiss="modal" style="font-family: 'Mulish' !important;">{!! __('label.cancel') !!}</button>
                <button class="btn btn-primary" type="submit" style="font-family: 'Mulish' !important;">{!! __('label.logout') !!}</button>
                </form>
            </div>
        </div>
        </div>
    </div>

    @include('alert')
    <main class="py-1" style="font-family: 'Mulish' !important">
        @yield('content')
    </main>

    <script src="{!! asset("js/moment.js?v=0.0.1") !!}"></script>
    <script src="{!! asset("bootstrap-datetimepicker/eonasdan-bootstrap-datetimepicker.js?v=0.0.01") !!}"></script>
	<script src="{!! url("datatables/jquery.dataTables.js") !!}"></script>
	<script src="{!! url("datatables/dataTables.bootstrap4.js") !!}"></script>
	<script src="{!! url("datatables/dataTables.responsive.min.js") !!}"></script>
    <script src="{!! asset("js/main.js?v=1.0.2") !!}"></script>
	<script src="{!! asset("js/sign/excanvas.js") !!}"></script>
	<script src="{!! asset("js/sign/signature_pad.min.js") !!}"></script>
    @yield("script")
</body>
</html>
