@extends('layouts.app')
@section('title', 'Accept Case')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/aor.css?v=1.0.1') }}">

<div class="cards-default">
    <div style="justify-content:space-between; display:flex;">
        <div class="div-box">
            <img style="width:15px; height:15px;" alt="cases" src="{{ asset('icon/cases.svg?v=1.0.0') }}">
            <div class="refno">{!! $record->Case_ReferenceId !!}</div>
        </div>
        <div style="justify-content:flex-start; display:flex">
            @if(!empty($record->Case_Opened))
            <div class="div-box">
                <div class="datesec">
                    <img style="width:16px; height:16px;" alt="date" src="{{ asset('icon/date.svg?v=1.0.0') }}">
                    {!! optional($record->Case_Opened)->format("d/m/Y") !!}
                </div>
                <div class="datesec">
                    <img style="width:15px; height:15px;" alt="clock" src="{{ asset('icon/clock.svg?v=1.0.0') }}">
                    {!! optional($record->Case_Opened)->format("H:i") !!}
                </div>

                @if(!empty($record->Contract) and $record->Contract->ctra_sla !="")
                <div class="refno">
                    SLA: {!! optional($record->Contract)->ctra_sla !!}
                </div>
                @endif

            </div>
             @endif
        </div>
    </div>

    @if(!empty($record->Company->Comp_Name))
    <div class="div-box">
        <img style="width:15px; height:15px;" alt="compname" src="{{ asset('icon/chome.svg?v=1.0.0') }}">
        <div class="div-text"> {!! $record->Company->Comp_Name !!} </div>
    </div>
    @endif

    @if(!empty($record->case_mladdr))
    <div class="div-box">
        <img style="width:15px; height:15px;" alt="address" src="{{ asset('icon/address.svg?v=1.0.0') }}">
        <div class="div-text"> {!! $record->case_mladdr ?? null !!}</div>
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


    <div class="sheet-container" style="justify-content: space-between;">
        <button id="reject" class="Secondary-btn">
            <span class="button">Reject</span>
            <img alt="Reject" src="{{ asset('icon/reject_cross.svg?v=1.0.0') }}"/>
        </button>

        <button id="accept" class="Primary-btn">
            <span class="buttonaccept">Accept</span>
            <img alt="Accept" src="{{ asset('icon/accept_tick.svg?v=1.0.0') }}"/>
        </button>
    </div>
</div>
@endsection
@section("script")
<script>
	$("#reject").on("click", function() {
		location.href="{!!route("cs.index")!!}"


	});

	$("#accept").on("click", function() {
		const response = confirm("Confirm Accept?");
		if (response) {

            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

			$.ajax({
				url: "{!!route("vtc.accept",["id"=>$record->getKey()])!!}",
				type: "post", //or get
				data: {

				},
				dataType: "text", //if the returned values need to be in json format
				success: function(_data){
					location.href='{!!route("cs.accept")!!}';
				}, //what to do if success
				error: function(_xhr, _stt, _st){

					alert("Error on Accept");

				}, //what to do if error
				complete: function(){

				} //what to do if complete (either success or error)
			});


		}

		});


</script>

@endsection
