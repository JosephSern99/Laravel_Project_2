@extends('layouts.app')
@section('title', 'Checklist')

@section('content')

<link rel="stylesheet" href="{{ URL::asset('css/checklistmain.css?v=1.0.1') }}">


@if(request()->input("type")=="onhand" or $record->Case_AssignedUserId==auth()->user()->getKey())
<div class="link-class" style="justify-content: space-between;">
    <a href="{!!route("cs.onhand")!!}"><img alt="Back" src="{{ asset('icon/back.svg?v=1.0.0') }}"></a>
    <span class="link-text">Back</span>
</div>
@else
<div class="link-class" style="justify-content: space-between;">
    <a href="{!!route("cs.accept")!!}"><img alt="Back" src="{{ asset('icon/back.svg?v=1.0.0') }}"></a>
    <span class="link-text">Back</span>
</div>
@endif

<div class="cards-default">
    <div class="div-box" style="justify-content: space-between;">
        <div class="div-text-green">
            Case Id : {!! $record->Case_ReferenceId !!}
        </div>
        @if($record->ServiceOrder)
        <div class="div-text-green">
            Service Date : {!! optional(optional($record->ServiceOrder)->svor_ServiceOrderDate)->format("d/m/Y") !!}
        </div>
        @endif
    </div>

    @if(!empty($record->ServiceOrder->svor_RefNo))
        <div class="div-box">
            <div class="div-text">
                Service Order :  {!! optional($record->ServiceOrder)->svor_RefNo !!}
            </div>
         </div>
    @endif
    @if(!empty($record->Company->Comp_Name))
        <div class="div-box">
            <div class="div-text">
                Customer : {!! $record->Company->Comp_Name !!}
            </div>
         </div>
    @endif

    <a href="{!!route("cs.servicedetails",["id"=>$record->getKey()])!!}">
    <div class="div-btn">
        <img alt="services" src="{{ asset('icon/services.svg?v=1.0.0') }}">
        <div class="div-text-green">
            Services
        </div>
    </div>
    </a>

    <a href="{!!route("cs.items1",["id"=>$record->getKey()])!!}">
    <div class="div-btn">
        <img alt="item" src="{{ asset('icon/items.svg?v=1.0.0') }}">
        <div class="div-text-green">
            Items
        </div>
    </div>
    </a>

    <a href="{!!route("cs.images",["id"=>$record->getKey()])!!}">
    <div class="div-btn">
        <img alt="images" src="{{ asset('icon/images.svg?v=1.0.0') }}">
        <div class="div-text-green">
            Images
        </div>
    </div>
    </a>

    <a href="{!!route("cs.signature",["id"=>$record->getKey()])!!}">
    <div class="div-btn">
        <img alt="signoff" src="{{ asset('icon/signoff.svg?v=1.0.0') }}">
        <div class="div-text-green">
            Sign Off
        </div>
    </div>
    </a>

    <a href="{!!route("cs.serviceorderlist",["customer"=>$record->Case_PrimaryCompanyId])!!}" target="_blank">
    <div class="div-btn">
        <img alt="customerinfo" src="{{ asset('icon/information.svg?v=1.0.0') }}">
        <div class="div-text-green">
            Customer Information
        </div>
    </div>
    </a>


</div>


@endsection
@section("script")
<script>
</script>

@endsection
