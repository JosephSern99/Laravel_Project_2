@extends('layouts.app')
@section('title', 'Service Details')

@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/servicedetails.css?v=1.0.4') }}">
<div class="link-class" style="justify-content: space-between; flex-wrap: wrap;
    display: flex;">
    <div>
        <a href="{!!route("cs.checklistmain",["id"=>$record->getKey()])!!}"><img alt="Back" src="{{ asset('icon/back.svg?v=1.0.0') }}"></a>
        <span class="link-text">Back</span>
    </div>
    <div>
        <span class="link-text">Next</span>
        <a href="{!!route("cs.items1",["id"=>$record->getKey()])!!}"><img alt="Next" src="{{ asset('icon/next.svg?v=1.0.0') }}"></a>
    </div>
</div>


<div class="cards-default">
    <div class="div-box">
        <img style="width:15px; height:15px;" alt="cases" src="{{ asset('icon/caselist.svg?v=1.0.0') }}">
        <div class="div-text-green">{!! $record->Case_ReferenceId !!}</div>
    </div>
    @if(!empty($record->ServiceOrder->svor_RefNo))
        <div class="div-box">
            <img style="width:15px; height:15px;" alt="person" src="{{ asset('icon/person.svg?v=1.0.0') }}">
            <div class="div-text">{!! optional($record->ServiceOrder)->svor_RefNo !!}</div>
        </div>
    @endif
    @if(!empty($record->ServiceOrder))
    <div class="div-box">
        <img style="width:15px; height:15px;" alt="date" src="{{ asset('icon/date.svg?v=1.0.0') }}">
        <div class="div-text">{!! optional($record->ServiceOrder)->svor_ServiceOrderDate->format("d/m/Y") !!} </div>
    </div>
    @endif
    <div class="div-box">
        <img style="width:15px; height:15px;" alt="customer" src="{{ asset('icon/chome.svg?v=1.0.0') }}">
        <div class="div-text"> {!! $record->Company->Comp_Name !!} </div>
    </div>
</div>

<div class="cards-default">
    <div class="div-title">Faults</div>
    <textarea id="svor_FaultReported" class="div-text-field" disabled>{!! optional($record->ServiceOrder)->svor_FaultReported ?? null !!}</textarea>
</div>

<div class="cards-default">
    <div class="div-title">Work Done</div>
    <textarea id="svor_WorkCarriedOut" class="div-text-field" disabled>{!! optional($record->ServiceOrder)->svor_WorkCarriedOut ?? null !!}</textarea>
</div>

<div class="cards-default">
    <div class="div-title">General Observations</div>
    <textarea id="svor_Observation" class="div-text-field" disabled>{!! optional($record->ServiceOrder)->svor_Observation ?? null !!}</textarea>
</div>


<div class="sheet-container">
    <button id="edit" class="Secondary-btn">
        <span class="button">Edit</span>
        <img alt="edit" src="{{ asset('icon/pencil.svg?v=1.0.0') }}"/>
    </button>

    <button id="save" class="Primary-btn">
        <span class="buttonsave">Save</span>
        <img alt="save" src="{{ asset('icon/save.svg?v=1.0.0') }}"/>
    </button>
</div>


@endsection
@section("script")
<script>
	$("#save").on("click", function() {
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

			$.ajax({
				url: "{!!route("cs.save",["id"=>$record->getKey()])!!}",
				type: "post", //or get
				data: {
					"svor_FaultReported":$("#svor_FaultReported").val(),
					"svor_WorkCarriedOut":$("#svor_WorkCarriedOut").val(),
                    "svor_Observation":$("#svor_Observation").val()


				},
				dataType: "json", //if the returned values need to be in json format
				success: function(_data){




				}, //what to do if success
				error: function(_xhr, _stt, _st){
					if (_xhr.status == 500) {
						alert("Input Error");
					}
				}, //what to do if error
				complete: function(){
					$("#svor_FaultReported").attr('disabled',true);
					$("#svor_WorkCarriedOut").attr('disabled',true);
                    $("#svor_Observation").attr('disabled',true);


				} //what to do if complete (either success or error)
			});

            $("#svor_FaultReported").css({"background-color":"#ebedf0"});
            $("#svor_WorkCarriedOut").css({"background-color":"#ebedf0"});
            $("#svor_Observation").css({"background-color":"#ebedf0"});


		});

	$("#edit").on("click", function() {
		$("#svor_FaultReported").attr('disabled',false);
		$("#svor_WorkCarriedOut").attr('disabled',false);
        $("#svor_Observation").attr('disabled',false);

        $("#svor_FaultReported").css({"background-color":"#fff"});
        $("#svor_WorkCarriedOut").css({"background-color":"#fff"});
        $("#svor_Observation").css({"background-color":"#fff"});
	});

</script>

@endsection
