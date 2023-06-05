@extends('layouts.app')
@section('title', __('Image Details'))



@section('content')

<link rel="stylesheet" href="{{ URL::asset('lightbox2-2.11.4/src/css/lightbox.css?v=1.0.0') }}">
<link rel="stylesheet" href="{{ URL::asset('css/imagesdetails.css?v=1.0.0') }}">
<link rel="stylesheet" href="{{ URL::asset('css/images.css?v=1.0.2') }}">
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/themes/smoothness/jquery-ui.css" rel="stylesheet"/>
<script src="{{ URL::asset('lightbox2-2.11.4/src/js/lightbox.js') }}"></script>


<div class="link-class" style="justify-content: space-between; flex-wrap: wrap;
    justify-content: space-between;
    display: flex;">
    <div>
        <a id="back"><img alt="Back" src="{{ asset('icon/back.svg?v=1.0.0') }}"></a>
        <span class="link-text">Back</span>
    </div>
    <div>
        <span class="link-text">Next</span>
        <a id="next"><img alt="Next" src="{{ asset('icon/next.svg?v=1.0.0') }}"></a>
    </div>
</div>

<div class="cards-default" style="justify-content: space-between; flex-wrap: wrap;
    display: flex;  overflow-y: auto;
    height:calc(100vh - 100px);
    overflow-x: hidden;">
@foreach($libraries as $lib)
<div>
<a href="{{ getLibraryRoute($lib->getKey()) }}" data-lightbox="images" data-title="Image"><img data-lightbox="images" style="width:135px; height:135px;"src="{{ getLibraryRoute($lib->getKey()) }}" alt="" title="" /></a>
</div>

@endforeach

</div>





@endsection
@section('script')

<!-- <script src="{!! url("fresh/app-assets/vendors/js/file-uploaders/dropzone.min.js") !!}"></script> -->
<script>


$("#back").on("click", function() {
    location.href="{!!route("cs.images", ["id"=>$records->svor_CaseId])!!}";
});

$("#next").on("click", function() {
    location.href="{!!route("cs.signature", ["id"=>$records->svor_CaseId] )!!}";
});

</script>
@endsection
