@extends('layouts.app')
@section('title', __('Information'))
@section('content')

<link rel="stylesheet" href="{{ URL::asset('css/serviceorderlist.css?v=1.0.2') }}">
<div class="sheet-container">
    <button class="ActionsService" id="service"><div class="Service">Service Orders</div>
        <img class="CompassService" alt="ServiceLogo" src="{{ asset('icon/service-green.svg?v=1.0.0') }}">
    </button>

    <button class="ActionsEquipment" id="equipment"><div class="Equipment">Equipment List</div>
        <img class="CompassEquipment" alt="EquipmentLogo" src="{{ asset('icon/equipment.svg?v=1.0.0') }}">
    </button>
</div>



<div class="Cases container-fluid p-0" style="height:calc(100vh - 245px);">
    <table class="dataTables_wrapper" id="ServiceDatatable">
        <thead class="bg-primary text-white" style="display:none;">
            <tr>
                <th>@lang("Case")</th>
            </tr>
        </thead>
        <tbody>
                @foreach($records as $record)
                <tr>
                    <td scope="row">

                        <div class="info-card">
                            @if(!empty($record->ServiceOrder))
                            <div class="Case-ID">
                                <img style="width:20px; height:20px;" class="casenum" alt="case" src="{{ asset('icon/cases.svg?v=1.0.0') }}">
                                <div class="refno"> Service Order : {!! $record->svor_RefNo !!}</div>
                            </div>
                            <div class="Customer"  style="justify-content: space-between;">
                                <div class="datesec">
                                    <img style="width:20px; height:20px;" alt="date" src="{{ asset('icon/date.svg?v=1.0.0') }}">
                                    Service Date: {!! optional($record->svor_ServiceOrderDate)->format("d/m/Y") !!}
                                </div>
                                <div class="datesec">
                                    <img style="width:20px; height:20px;" alt="clock" src="{{ asset('icon/clock.svg?v=1.0.0') }}">
                                    {!! optional($record->svor_ServiceOrderDate)->format("H:i") !!}
                                </div>

                            </div>
                            @endif
                            <div class="Case-ID">
                                <img style="width:20px; height:20px;" class="casenum" alt="case" src="{{ asset('icon/cases.svg?v=1.0.0') }}">
                                <div class="refno">Cases ID: {!! $record->Cases->Case_ReferenceId !!}</div>
                            </div>
                            <div class="Customer">
                                <img style="width:20px; height:20px;" alt="chome" src="{{ asset('icon/chome.svg?v=1.0.0') }}">
                                <div class="custname">{!! $record->Company->Comp_Name !!}</div>
                            </div>

                            <div class="Customer">
                                <img style="width:20px; height:20px;" alt="fault" src="{{ asset('icon/fault.svg?v=1.0.0') }}">
                                <div class="custname">Fault Reported : {!! $record->svor_FaultReported !!}</div>
                            </div>

                            <div class="Customer">
                                <img style="width:20px; height:20px;" alt="fault" src="{{ asset('icon/service-green.svg?v=1.0.0') }}">
                                <div class="custname">Work Carried Out : {!! $record->svor_WorkCarriedOut !!}</div>
                            </div>
                            @if(!empty($record->svor_datefrom))
                            <div class="Customer"  style="justify-content: space-between;">
                                <div class="datesec">
                                    <img style="width:20px; height:20px;" alt="date" src="{{ asset('icon/date.svg?v=1.0.0') }}">
                                    Check In : {!! optional($record->svor_datefrom)->format("d/m/Y") !!}
                                </div>
                                <div class="datesec">
                                    <img style="width:20px; height:20px;" alt="clock" src="{{ asset('icon/clock.svg?v=1.0.0') }}">
                                    {!! optional($record->svor_datefrom)->format("H:i") !!}
                                </div>

                            </div>
                            @endif
                            @if(!empty($record->svor_dateto))
                            <div class="Customer"  style="justify-content: space-between;">
                                <div class="datesec">
                                    <img style="width:20px; height:20px;" alt="date" src="{{ asset('icon/date.svg?v=1.0.0') }}">
                                    Check Out : {!! optional($record->svor_dateto)->format("d/m/Y") !!}
                                </div>
                                <div class="datesec">
                                    <img style="width:20px; height:20px;" alt="clock" src="{{ asset('icon/clock.svg?v=1.0.0') }}">
                                    {!! optional($record->svor_dateto)->format("H:i") !!}
                                </div>

                            </div>
                            @endif

                            <div class="Customer">
                                <img style="width:20px; height:20px;" alt="contract" src="{{ asset('icon/contract.svg?v=1.0.0') }}">
                                <div class="numofservicetext">  Contract :  {!! $contract->ctra_Description ?? null !!}</div>
                            </div>

                        </div>

                    </td>
                </tr>
                @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('script')
<script>
$(function(){
	var table = $("#ServiceDatatable").DataTable({
        scrollX: false,
        scrollY: 385,

        "sDom": '<"top"lf>irt<"bottom"p><"clear">',
        pageLength : 3,
	    lengthMenu: [
            [10, 20, -1],
            [10, 20, 'All'],
        ],
        stateSave: true,
        "bFilter" : true,
        "bInfo": true,
        "responsive" : true,
        "iDisplayLength": 10,
        "pageLength": 10,
        language: {
            "info": "_END_ out of _TOTAL_ results",
            // "infoFiltered": "",
            // search: "",
            paginate: {
                next: '>',
                previous: '<',
                first:'<<',
                last:'>>'
            }
        }
	});



    var prevTop = 0;
    $('div.dataTables_scrollBody').scroll( function(evt) {
    var currentTop = $(this).scrollTop();
    if(prevTop !== currentTop) {
        prevTop = currentTop;
            if(currentTop + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            }
        }
    });


});


$("#service").on("click", function() {

location.href="{!!route("cs.serviceorderlist",["customer"=>$record->svor_CompanyId])!!}";

});

$("#equipment").on("click", function() {

location.href="{!!route("cs.equipmentlist",["customer"=>$record->svor_CompanyId])!!}";

});


</script>
@endsection
