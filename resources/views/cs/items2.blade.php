@extends('layouts.app')
@section('title', 'Items Summary')

@section('content')

<link rel="stylesheet" href="{{ URL::asset('css/items2.css?v=1.0.4') }}">




<div class="link-class" style="justify-content: space-between; flex-wrap: wrap;
    justify-content: space-between;
    display: flex;">
    <div>
        <a href="{!!route("cs.items1",["id"=>$record->getKey()])!!}"><img alt="Back" src="{{ asset('icon/back.svg?v=1.0.0') }}"></a>
        <span class="link-text">Back</span>
    </div>
    <div>
        <span class="link-text">Next</span>
        <a href="{!!route("cs.images",["id"=>$record->getKey()])!!}"><img alt="Next" src="{{ asset('icon/next.svg?v=1.0.0') }}"></a>
    </div>
</div>


<div class="cards-default" style="justify-content: space-between; flex-wrap: wrap;
    display: flex;">

    <div class="div-box">
        <img style="width:15px; height:15px;" alt="cases" src="{{ asset('icon/caselist.svg?v=1.0.0') }}">
        <div class="div-text-green">{!! $record->Case_ReferenceId !!}</div>
    </div>

    <div class="div-box">
        <img style="width:16px; height:16px;" alt="date" src="{{ asset('icon/date.svg?v=1.0.0') }}">
        <div class="div-text"> {!! optional($record->Case_Opened)->format("d/m/Y") !!}</div>
    </div>

</div>


<div style="
    margin-left:16px;
    margin-right:16px;
    width:auto;
    overflow-y: auto;
    height:calc(100vh - 370px);
    overflow-x: hidden;
    font-family: 'Mulish';
">

@foreach($products as $product)
    <div class="items">
        <div class="item-name">{!!$product->svit_Name!!}</div>
        <div class="div-box" style="justify-content: space-between; flex-wrap: wrap;
        display: flex;">
            <div class="div-text" style="font-size:12px;">Quantity: </div>
            <div class="div-text" style="font-size:12px;">{!! number_format($product->svit_quantity) !!}</div>
        </div>
        <div class="div-box" style="justify-content: space-between; flex-wrap: wrap;
        display: flex;">
            <div class="div-text" style="font-size:12px;">Unit Price:</div>
            <div class="div-text" style="font-size:12px;">$ {!! number_format(round($product->svit_unitprice, 2),2) !!}</div>
        </div>

        <div class="div-box" style="justify-content: space-between; flex-wrap: wrap;
        display: flex;">
            <div class="div-text-green" style="font-size:12px;">Subtotal:</div>
            <div class="div-text-green" style="font-size:12px;">$ {!! number_format(round($product->svit_pricetotal, 2),2) !!}</div>
        </div>
    </div>
    @endforeach

</div>





<div class="total">
    <div style="justify-content: space-between; flex-wrap: wrap; display: flex;">
    <div style="justify-content: space-between; flex-wrap: wrap;">
    <div class="labeltotal">Total Price</div>
    <div class="total-price" id="totalprice" name="totalprice" style="color: #265B55 !important; font-size:16px; border:none; height:auto;">$ {!! number_format(round($sorecord->svor_totalprice,2),2) !!}</div>
    </div>
    <button id="proceed" class="btn-proceed" type="button">Proceed</button>
    </div>
</div>



@endsection
@section("script")
<script>


$(function(){
    $("#proceed").on("click", function(){
        location.href = "{!! route("cs.images",["id"=>$id])!!}";

    });
});

</script>
@endsection
