@extends('layouts.app')
@section('title', 'Check In')

@section('content')
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/themes/smoothness/jquery-ui.css" rel="stylesheet"/>

<link rel="stylesheet" href="{{ URL::asset('css/servicecheckin.css?v=1.0.5') }}">
<div id="dialog-confirm"></div>
<div class="link-class" style="justify-content: space-between; flex-wrap: wrap;
    justify-content: space-between;
    display: flex;">
    @if($record->Case_AssignedUserId==auth()->user()->getKey())
    <div>
        <a href="{!!route("cs.onhand")!!}"><img alt="Back" src="{{ asset('icon/back.svg?v=1.0.0') }}"></a>
        <span class="link-text">Back</span>
    </div>

    @else
    <div>
        <a href="{!!route("cs.accept")!!}"><img alt="Back" src="{{ asset('icon/back.svg?v=1.0.0') }}"></a>
        <span class="link-text">Back</span>
    </div>
    @endif
</div>

<div class="cards-default">
    <div style="justify-content:space-between; flex-wrap: wrap; display: flex;">
        <div class="div-box">
            <img style="width:15px; height:15px;" alt="cases" src="{{ asset('icon/caselist.svg?v=1.0.0') }}">
            <div class="refno">{!! $record->Case_ReferenceId !!}</div>
        </div>
        <div class="div-box"  style="justify-content:flex-start; display:flex;">
            <div class="div-text">
                <img style="width:16px; height:16px;" alt="date" src="{{ asset('icon/date.svg?v=1.0.0') }}">
                {!! optional($record->Case_Opened)->format("d/m/Y") !!}
            </div>
            <div class="div-text">
                <img style="width:15px; height:15px;" alt="clock" src="{{ asset('icon/clock.svg?v=1.0.0') }}">
                {!! optional($record->Case_Opened)->format("H:i") !!}
            </div>
            @if(!empty($record->Contract) and $record->Contract->ctra_sla !="")
            <div class="refno">
                SLA: {!! optional($record->Contract)->ctra_sla !!}
            </div>
            @endif
        </div>
    </div>
    <div class="div-box">
        <img style="width:15px; height:15px;" alt="customer" src="{{ asset('icon/chome.svg?v=1.0.0') }}">
        <div class="div-text"> {!! $record->Company->Comp_Name !!} </div>
    </div>

    @if(!empty( $record->case_mladdr ))
    <div class="div-box">
        <img style="width:15px; height:15px;" alt="case" src="{{ asset('icon/address.svg?v=1.0.0') }}">
        <div class="div-text">Site Location: {!! $record->case_mladdr !!}</div>
    </div>
    @endif

    @if(!empty($record->Contract))
        @if($record->case_type == 'Adhoc')
        <div class="div-box" style="justify-content:flex-start;">
            <img style="width:15px; height:15px;" alt="contract" src="{{ asset('icon/contract.svg?v=1.0.0') }}">
            <div class="div-text">{!! optional($record->Contract)->ctra_Type!!}</div>
            <div class="div-text">No. of Service Calls : {!! optional($record->Contract)->ctra_numofsvcall !!}</div>
        </div>
        @elseif($record->case_type == 'Preventive')
        <div class="div-box">
            <img style="width:15px; height:15px;" alt="contract" src="{{ asset('icon/contract.svg?v=1.0.0') }}">
            <div class="div-text">{!! optional($record->Contract)->ctra_Type!!}</div>
            <div class="div-text">No. of PM : {!! optional($record->Contract)->ctra_numofpm!!}</div>
        </div>
        @endif
    @endif

    @if(!empty($record->Case_Description))
    <div class="div-box">
        <img style="width:15px; height:15px;" alt="case" src="{{ asset('icon/fault.svg?v=1.0.0') }}">
        <div class="div-text">{!! $record->Case_Description !!}</div>
    </div>
    @endif

    @if(!empty($record->Case_ProblemNote))
    <div class="div-box">
        <img style="width:15px; height:15px;" alt="case" src="{{ asset('icon/fault.svg?v=1.0.0') }}">
        <div class="div-text">{!! $record->Case_ProblemNote !!}</div>
    </div>
    @endif


    <div style="justify-content:space-between; display:flex">
        @if(!empty($record->case_ContactName ))
        <div class="div-box">
            <img style="width:15px; height:15px;" alt="case" src="{{ asset('icon/person.svg?v=1.0.0') }}">
            <div class="div-text">{!! $record->case_ContactName !!}</div>
        </div>
        @endif
        @if(!empty($record->case_ContactNumber ))
        <div class="div-box">
            <img style="width:15px; height:15px;" alt="case" src="{{ asset('icon/phone.svg?v=1.0.0') }}">
            <div class="div-text">{!! $record->case_ContactNumber !!}</div>
        </div>
        @endif
    </div>





    <!-- @if(!empty($record->ServiceOrder))
        <div class="div-box">
            <img style="width:15px; height:15px;" alt="serviceorder" src="{{ asset('icon/caselist.svg?v=1.0.0') }}">
            <div class="div-text-green">Service Order :  {!! optional($record->ServiceOrder)->svor_RefNo !!}</div>
        </div>

        <div class="div-box"  style="justify-content: space-between;">
            <div class="div-text">
                <img style="width:16px; height:16px;" alt="date" src="{{ asset('icon/date.svg?v=1.0.0') }}">
                Service Date : {!! optional($record->ServiceOrder)->svor_ServiceOrderDate->format("d/m/Y") !!}
            </div>
            <div class="div-text">
                <img style="width:15px; height:15px;" alt="clock" src="{{ asset('icon/clock.svg?v=1.0.0') }}">
                {!! optional($record->ServiceOrder)->svor_ServiceOrderDate->format("H:i") !!}
            </div>
        </div>
    @endif -->


</div>


<!-- <div class="cards-default">
    <div class="div-box">
        <img style="width:15px; height:15px;" alt="serviceorder" src="{{ asset('icon/cases.svg?v=1.0.0') }}">
        <div class="div-text">System : {!! optional($record->ServiceOrder)->svor_SystemType !!}</div>
    </div>

    <div class="div-box">
        <img style="width:15px; height:15px;" alt="serviceorder" src="{{ asset('icon/cases.svg?v=1.0.0') }}">
        <div class="div-text">Mode : {!! optional($record->ServiceOrder)->svor_mode !!}</div>
    </div>

    <div class="div-box">
        <img style="width:15px; height:15px;" alt="contract" src="{{ asset('icon/contract.svg?v=1.0.0') }}">
        <div class="div-text">
            <div class="div-text">Service</div>
            <div class="div-text">Type : {!! optional($record->ServiceOrder)->svor_ServiceType !!} </div>
            <div class="div-text">Term : 30 </div>

        </div>
    </div>
</div> -->

<div class="sheet-container">
    <button class="Secondary-btn btn-cancel" cancelid="{!! $record->Case_CaseId  !!}"><span class="buttontext">{{ __('Cancel') }}</span></button>
    <button class="Secondary-btn btn-release" releaseid="{!! $record->Case_CaseId  !!}"><span class="buttontext">{{ __('Release') }}</span></button>
    <button id="checkin" class="Primary-btn">
        <span class="buttoncheckin">Check In</span>
        <img alt="save" style="width:15px; height:15px;" src="{{ asset('icon/clock.png?v=1.0.0') }}"/>
    </button>
</div>



@endsection
@section("script")
<script>


$(".btn-cancel").on("click",function buttonAction() {
	let _this = $(this), _cancelid = _this.attr("cancelid") || "";
	if(_cancelid != ""){


            // Define the Dialog and its properties.
            $("#dialog-confirm").dialog({
                dialogClass: 'no-close',
                modal: true,
                title: 'Confirm Cancel?',
                zIndex: 10000,
                autoOpen: true,
                width: '250px',
                resizable: false,
                buttons: {
                "No": {
                    text: "No",
                    class: "button-no leftButton",
                    click: function() {

                    $(this).dialog('close');
                        // location.reload();
                    }
                },
                "Yes": {
                            text: "Yes",
                            class: "button-yes",
                            click: function() {

                            // $(this).dialog('close');
                            $.ajax({
                            url: "{!! route("cs.cancel") !!}",
                            type: "get", //or get
                            data: {
                            "id" : _cancelid
                            },
                            success: function(_data){

                            }, //what to do if success
                            error: function(_xhr, _stt, _st){

                            alert("Error on Cancel");

                            }, //what to do if error
                            complete: function(){
                            location.href="{!!route("cs.accept")!!}"

                            } //what to do if complete (either success or error)
                            });

                        }
                    }
                }
            });





    }

});




$(".btn-release").on("click",function buttonAction() {
	let _this = $(this), _releaseid = _this.attr("releaseid") || "";
	if(_releaseid != ""){


            // Define the Dialog and its properties.
            $("#dialog-confirm").dialog({
                dialogClass: 'no-close',
                modal: true,
                title: 'Confirm Release?',
                zIndex: 10000,
                autoOpen: true,
                width: '250px',
                resizable: false,
                buttons: {
                "No": {
                    text: "No",
                    class: "button-no leftButton",
                    click: function() {

                    $(this).dialog('close');
                        // location.reload();
                    }
                },
                "Yes": {
                            text: "Yes",
                            class: "button-yes",
                            click: function() {

                            // $(this).dialog('close');
                            $.ajax({
                            url: "{!! route("cs.release") !!}",
                            type: "get", //or get
                            data: {
                            "id" : _releaseid
                            },
                            success: function(_data){

                            }, //what to do if success
                            error: function(_xhr, _stt, _st){

                            alert("Error on Release");

                            }, //what to do if error
                            complete: function(){
                            location.href="{!!route("cs.accept")!!}"

                            } //what to do if complete (either success or error)
                            });

                        }
                    }
                }
            });





    }

});


$("#checkin").on("click", function() {
		const response = confirm("Confirm Check In?");

		if (response) {
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

			$.ajax({
					url: "{!!route("cs.servicecheckinnow",["id"=>$record->getKey()])!!}",
					type: "post", //or get
					data: {

					},
					dataType: "text", //if the returned values need to be in json format
					success: function(_data){

                        location.href="{!!route("cs.checklistmain",["id"=>$record->getKey()])!!}"

					}, //what to do if success
					error: function(_xhr, _stt, _st){
						alert("Error on Check in");

					}, //what to do if error
					complete: function(){

					} //what to do if complete (either success or error)
				});


		}


	});

</script>


@endsection
