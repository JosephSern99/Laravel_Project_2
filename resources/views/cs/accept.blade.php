@extends('layouts.app')
@section('title', __('table.casesummary'))
@section('content')



<link rel="stylesheet" href="{{ URL::asset('css/accept.css?v=1.0.8') }}">



@if($channel != [])
<div class="sheet-container">
    <button class="ActionsAdhoc" id="adhoc"><div class="Adhoc">Adhoc</div>
        <img class="CompassAdhoc" alt="AdhocLogo" src="{{ asset('icon/adhoc_black.svg?v=1.0.0') }}">
    </button>

    <button class="ActionsPrevent" id="prevent"><div class="Prevent">Preventive</div>
        <img class="CompassPrevent" alt="PreventLogo" src="{{ asset('icon/preventive.svg?v=1.0.0') }}">
    </button>


    <button class="ActionsAccept" id="accept"><div class="Accept">Accepted</div>
        <img class="CompassAccept" alt="AcceptLogo" src="{{ asset('icon/accept_green.svg?v=1.0.0') }}">
    </button>

    <button class="ActionsOnHand" id="onhand"><div class="OnHand">On Hand</div>
        <img class="CompassOnHand" alt="OnHandLogo" src="{{ asset('icon/onhand.svg?v=1.0.0') }}">
    </button>

</div>

@else
<div class="sheet-container">
    <button class="ActionsAdhocA" id="adhoc"><div class="Adhoc">Adhoc</div>
        <img class="CompassAdhoc" alt="AdhocLogo" src="{{ asset('icon/adhoc_black.svg?v=1.0.0') }}">
    </button>

    <button class="ActionsAcceptA" id="accept"><div class="Accept">Accepted</div>
        <img class="CompassAccept" alt="AcceptLogo" src="{{ asset('icon/accept_green.svg?v=1.0.0') }}">
    </button>

    <button class="ActionsPreventA" id="prevent"><div class="Prevent">Preventive</div>
        <img class="CompassPrevent" alt="PreventLogo" src="{{ asset('icon/preventive.svg?v=1.0.0') }}">
    </button>

    <button class="ActionsOnHandA" id="project"><div class="OnHand">Project</div>
        <img class="CompassOnHand" alt="ProjectLogo" src="{{ asset('icon/Cases_black.svg?v=1.0.0') }}">
    </button>

    <button class="ActionsOnHandA" id="cabling"><div class="OnHand">Cabling</div>
        <img class="CompassOnHand" alt="CablingLogo" src="{{ asset('icon/service-black.svg?v=1.0.0') }}">
    </button>

    <button class="ActionsOnHandA" id="service"><div class="OnHand">Service</div>
        <img class="CompassOnHand" alt="ServiceLogo" src="{{ asset('icon/service-black.svg?v=1.0.0') }}">
    </button>
</div>

@endif


<div class="Cases container-fluid p-0" style="height:calc(100vh - 315px);">
        <table class="dataTables_wrapper" id="AcceptDatatable">
            <thead class="bg-primary text-white" style="display:none;">
                <tr>
                    <th scope="col">@lang("Case")</th>
                </tr>
            </thead>
            <tbody>
            @foreach($records as $record)
            <tr>
                <td scope="row">
                @if($record->case_type == "Adhoc" and empty($record->Case_AssignedUserId))
                <a href="{!!route("cs.index")!!}">
                    <div class="info-card">
                        <div style="justify-content:space-between; flex-wrap: wrap; display: flex;">
                            <div class="Case-ID">
                                <img style="width:20px; height:20px;" class="casenum" alt="case" src="{{ asset('icon/cases.svg?v=1.0.0') }}">
                                <div class="refno">{!! $record->Case_ReferenceId !!}</div>
                            </div>
                            <div style="justify-content:flex-start; display:flex">
                                @if(!empty($record->Case_Opened))
                                <div class="Customer">
                                    <div class="datesec">
                                        <img style="width:20px; height:20px;" alt="date" src="{{ asset('icon/date.svg?v=1.0.0') }}">
                                        {!! optional($record->Case_Opened)->format("d/m/Y") !!}
                                    </div>

                                    <div class="datesec">
                                        <img style="width:20px; height:20px;" alt="clock" src="{{ asset('icon/clock.svg?v=1.0.0') }}">
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

                        <div class="Customer">
                            <img style="width:20px; height:20px;" alt="chome" src="{{ asset('icon/chome.svg?v=1.0.0') }}">
                            <div class="custname">{!! $record->Company->Comp_Name !!}</div>
                        </div>
                        @if(!empty( $record->case_mladdr ))
                        <div class="Customer">
                            <img style="width:20px; height:20px;" alt="case" src="{{ asset('icon/address.svg?v=1.0.0') }}">
                            <div class="contracttext">{!! $record->case_mladdr !!}</div>
                        </div>
                        @endif

                        @if(!empty($record->Contract))
                            @if($record->case_type == 'Adhoc')
                            <div class="Customer" style="justify-content:flex-start;">
                                <img style="width:20px; height:20px;" alt="contract" src="{{ asset('icon/contract.svg?v=1.0.0') }}">
                                <div class="contracttext">{!! optional($record->Contract)->ctra_Type!!}</div>
                                <div class="numofservicetext">No. of Service Calls : {!! optional($record->Contract)->ctra_numofsvcall !!}</div>
                            </div>
                            @elseif($record->case_type == 'Preventive')
                            <div class="Customer">
                                <img style="width:20px; height:20px;" alt="contract" src="{{ asset('icon/contract.svg?v=1.0.0') }}">
                                <div class="contracttext">{!! optional($record->Contract)->ctra_Type!!}</div>
                                <div class="numofservicetext">No. of PM : {!! optional($record->Contract)->ctra_numofpm!!}</div>
                            </div>
                            @endif
                        @endif
                        <div style="justify-content:space-between; display:flex;">
                            @if(!empty($record->Case_Description))
                            <div class="Customer">
                                <img style="width:20px; height:20px;" alt="case" src="{{ asset('icon/fault.svg?v=1.0.0') }}">
                                <div class="problemnote">{!! $record->Case_Description !!}</div>
                            </div>
                            @endif

                            @if(!empty($record->Person))
                            <div class="Customer">
                                <img style="width:20px; height:20px;" alt="pers" src="{{ asset('icon/person.svg?v=1.0.0') }}">
                                <div class="userfname"> {!! $record->User->User_FirstName !!} {!! $record->User->User_LastName !!} </div>
                            </div>
                            @endif
                        </div>

                        @if(!empty($record->Case_AssignedUserId))
                        <div class="Customer">
                            <img style="width:20px; height:20px;" alt="pers" src="{{ asset('icon/person.svg?v=1.0.0') }}">
                            <div class="userfname">{!! optional($record->Person)->Pers_FirstName !!} </div>
                        </div>
                        @endif
                    </div>

                </a>
                @elseif($record->case_type == "Preventive" and empty($record->Case_AssignedUserId))
                <a href="{!!route("cs.prevent")!!}">
                    <div class="info-card">
                        <div style="justify-content:space-between; flex-wrap: wrap; display: flex;">
                            <div class="Case-ID">
                                <img style="width:20px; height:20px;" class="casenum" alt="case" src="{{ asset('icon/cases.svg?v=1.0.0') }}">
                                <div class="refno">{!! $record->Case_ReferenceId !!}</div>
                            </div>
                            <div style="justify-content:flex-start; display:flex">
                                @if(!empty($record->Case_Opened))
                                <div class="Customer">
                                    <div class="datesec">
                                        <img style="width:20px; height:20px;" alt="date" src="{{ asset('icon/date.svg?v=1.0.0') }}">
                                        {!! optional($record->Case_Opened)->format("d/m/Y") !!}
                                    </div>

                                    <div class="datesec">
                                        <img style="width:20px; height:20px;" alt="clock" src="{{ asset('icon/clock.svg?v=1.0.0') }}">
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

                        <div class="Customer">
                            <img style="width:20px; height:20px;" alt="chome" src="{{ asset('icon/chome.svg?v=1.0.0') }}">
                            <div class="custname">{!! $record->Company->Comp_Name !!}</div>
                        </div>
                        @if(!empty( $record->case_mladdr ))
                        <div class="Customer">
                            <img style="width:20px; height:20px;" alt="case" src="{{ asset('icon/address.svg?v=1.0.0') }}">
                            <div class="contracttext">{!! $record->case_mladdr !!}</div>
                        </div>
                        @endif

                        @if(!empty($record->Contract))
                            @if($record->case_type == 'Adhoc')
                            <div class="Customer" style="justify-content:flex-start;">
                                <img style="width:20px; height:20px;" alt="contract" src="{{ asset('icon/contract.svg?v=1.0.0') }}">
                                <div class="contracttext">{!! optional($record->Contract)->ctra_Type!!}</div>
                                <div class="numofservicetext">No. of Service Calls : {!! optional($record->Contract)->ctra_numofsvcall !!}</div>
                            </div>
                            @elseif($record->case_type == 'Preventive')
                            <div class="Customer">
                                <img style="width:20px; height:20px;" alt="contract" src="{{ asset('icon/contract.svg?v=1.0.0') }}">
                                <div class="contracttext">{!! optional($record->Contract)->ctra_Type!!}</div>
                                <div class="numofservicetext">No. of PM : {!! optional($record->Contract)->ctra_numofpm!!}</div>
                            </div>
                            @endif
                        @endif
                        <div style="justify-content:space-between; display:flex;">
                            @if(!empty($record->Case_Description))
                            <div class="Customer">
                                <img style="width:20px; height:20px;" alt="case" src="{{ asset('icon/fault.svg?v=1.0.0') }}">
                                <div class="problemnote">{!! $record->Case_Description !!}</div>
                            </div>
                            @endif

                            @if(!empty($record->Person))
                            <div class="Customer">
                                <img style="width:20px; height:20px;" alt="pers" src="{{ asset('icon/person.svg?v=1.0.0') }}">
                                <div class="userfname"> {!! $record->User->User_FirstName !!} {!! $record->User->User_LastName !!} </div>
                            </div>
                            @endif
                        </div>

                        @if(!empty($record->Case_AssignedUserId))
                        <div class="Customer">
                            <img style="width:20px; height:20px;" alt="pers" src="{{ asset('icon/person.svg?v=1.0.0') }}">
                            <div class="userfname">{!! optional($record->Person)->Pers_FirstName !!} </div>
                        </div>
                        @endif
                    </div>

                </a>
                @elseif(!empty($record->Case_AssignedUserId))
                    @if(empty($record->ServiceOrder->svor_datefrom))
                        <a href="{!!route("cs.servicecheckin",["id"=>$record->getKey()])!!}">
                            <div class="info-card">
                                <div style="justify-content:space-between; flex-wrap: wrap; display: flex;">
                                    <div class="Case-ID">
                                        <img style="width:20px; height:20px;" class="casenum" alt="case" src="{{ asset('icon/cases.svg?v=1.0.0') }}">
                                        <div class="refno">{!! $record->Case_ReferenceId !!}</div>
                                    </div>
                                    <div style="justify-content:flex-start; display:flex">
                                        @if(!empty($record->Case_Opened))
                                        <div class="Customer">
                                            <div class="datesec">
                                                <img style="width:20px; height:20px;" alt="date" src="{{ asset('icon/date.svg?v=1.0.0') }}">
                                                {!! optional($record->Case_Opened)->format("d/m/Y") !!}
                                            </div>

                                            <div class="datesec">
                                                <img style="width:20px; height:20px;" alt="clock" src="{{ asset('icon/clock.svg?v=1.0.0') }}">
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

                                <div class="Customer">
                                    <img style="width:20px; height:20px;" alt="chome" src="{{ asset('icon/chome.svg?v=1.0.0') }}">
                                    <div class="custname">{!! $record->Company->Comp_Name !!}</div>
                                </div>
                                @if(!empty( $record->case_mladdr ))
                                <div class="Customer">
                                    <img style="width:20px; height:20px;" alt="case" src="{{ asset('icon/address.svg?v=1.0.0') }}">
                                    <div class="contracttext">{!! $record->case_mladdr !!}</div>
                                </div>
                                @endif

                                @if(!empty($record->Contract))
                                    @if($record->case_type == 'Adhoc')
                                    <div class="Customer" style="justify-content:flex-start;">
                                        <img style="width:20px; height:20px;" alt="contract" src="{{ asset('icon/contract.svg?v=1.0.0') }}">
                                        <div class="contracttext">{!! optional($record->Contract)->ctra_Type!!}</div>
                                        <div class="numofservicetext">No. of Service Calls : {!! optional($record->Contract)->ctra_numofsvcall !!}</div>
                                    </div>
                                    @elseif($record->case_type == 'Preventive')
                                    <div class="Customer">
                                        <img style="width:20px; height:20px;" alt="contract" src="{{ asset('icon/contract.svg?v=1.0.0') }}">
                                        <div class="contracttext">{!! optional($record->Contract)->ctra_Type!!}</div>
                                        <div class="numofservicetext">No. of PM : {!! optional($record->Contract)->ctra_numofpm!!}</div>
                                    </div>
                                    @endif
                                @endif
                                <div style="justify-content:space-between; display:flex;">
                                    @if(!empty($record->Case_Description))
                                    <div class="Customer">
                                        <img style="width:20px; height:20px;" alt="case" src="{{ asset('icon/fault.svg?v=1.0.0') }}">
                                        <div class="problemnote">{!! $record->Case_Description !!}</div>
                                    </div>
                                    @endif

                                    @if(!empty($record->Person))
                                    <div class="Customer">
                                        <img style="width:20px; height:20px;" alt="pers" src="{{ asset('icon/person.svg?v=1.0.0') }}">
                                        <div class="userfname"> {!! $record->User->User_FirstName !!} {!! $record->User->User_LastName !!} </div>
                                    </div>
                                    @endif
                                </div>

                                @if(!empty($record->Case_AssignedUserId))
                                <div class="Customer">
                                    <img style="width:20px; height:20px;" alt="pers" src="{{ asset('icon/person.svg?v=1.0.0') }}">
                                    <div class="userfname">{!! optional($record->Person)->Pers_FirstName !!} </div>
                                </div>
                                @endif
                            </div>

                        </a>

                        <!-- <button releaseid="{!! $record->Case_CaseId !!}" class="btn btn-secondary btn-release" class="btn btn-outline-secondary">{{ __('Release') }}</button> -->

                    @else
                        <a href="{!!route("cs.checklistmain",["id"=>$record->getKey()])!!}">
                            <div class="info-card">
                                <div style="justify-content:space-between; flex-wrap: wrap; display: flex;">
                                    <div class="Case-ID">
                                        <img style="width:20px; height:20px;" class="casenum" alt="case" src="{{ asset('icon/cases.svg?v=1.0.0') }}">
                                        <div class="refno">{!! $record->Case_ReferenceId !!}</div>
                                    </div>
                                    <div style="justify-content:flex-start; display:flex">
                                        @if(!empty($record->Case_Opened))
                                        <div class="Customer">
                                            <div class="datesec">
                                                <img style="width:20px; height:20px;" alt="date" src="{{ asset('icon/date.svg?v=1.0.0') }}">
                                                {!! optional($record->Case_Opened)->format("d/m/Y") !!}
                                            </div>

                                            <div class="datesec">
                                                <img style="width:20px; height:20px;" alt="clock" src="{{ asset('icon/clock.svg?v=1.0.0') }}">
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

                                <div class="Customer">
                                    <img style="width:20px; height:20px;" alt="chome" src="{{ asset('icon/chome.svg?v=1.0.0') }}">
                                    <div class="custname">{!! $record->Company->Comp_Name !!}</div>
                                </div>
                                @if(!empty( $record->case_mladdr ))
                                <div class="Customer">
                                    <img style="width:20px; height:20px;" alt="case" src="{{ asset('icon/address.svg?v=1.0.0') }}">
                                    <div class="contracttext">{!! $record->case_mladdr !!}</div>
                                </div>
                                @endif

                                @if(!empty($record->Contract))
                                    @if($record->case_type == 'Adhoc')
                                    <div class="Customer" style="justify-content:flex-start;">
                                        <img style="width:20px; height:20px;" alt="contract" src="{{ asset('icon/contract.svg?v=1.0.0') }}">
                                        <div class="contracttext">{!! optional($record->Contract)->ctra_Type!!}</div>
                                        <div class="numofservicetext">No. of Service Calls : {!! optional($record->Contract)->ctra_numofsvcall !!}</div>
                                    </div>
                                    @elseif($record->case_type == 'Preventive')
                                    <div class="Customer">
                                        <img style="width:20px; height:20px;" alt="contract" src="{{ asset('icon/contract.svg?v=1.0.0') }}">
                                        <div class="contracttext">{!! optional($record->Contract)->ctra_Type!!}</div>
                                        <div class="numofservicetext">No. of PM : {!! optional($record->Contract)->ctra_numofpm!!}</div>
                                    </div>
                                    @endif
                                @endif
                                <div style="justify-content:space-between; display:flex;">
                                    @if(!empty($record->Case_Description))
                                    <div class="Customer">
                                        <img style="width:20px; height:20px;" alt="case" src="{{ asset('icon/fault.svg?v=1.0.0') }}">
                                        <div class="problemnote">{!! $record->Case_Description !!}</div>
                                    </div>
                                    @endif

                                    @if(!empty($record->Person))
                                    <div class="Customer">
                                        <img style="width:20px; height:20px;" alt="pers" src="{{ asset('icon/person.svg?v=1.0.0') }}">
                                        <div class="userfname"> {!! $record->User->User_FirstName !!} {!! $record->User->User_LastName !!} </div>
                                    </div>
                                    @endif
                                </div>

                                @if(!empty($record->Case_AssignedUserId))
                                <div class="Customer">
                                    <img style="width:20px; height:20px;" alt="pers" src="{{ asset('icon/person.svg?v=1.0.0') }}">
                                    <div class="userfname">{!! optional($record->Person)->Pers_FirstName !!} </div>
                                </div>
                                @endif
                            </div>

                        </a>

                    @endif


                @elseif($record->case_type == "On_Hand")
                <a href="{!!route("cs.onhand")!!}">
                    <div class="info-card">
                        <div style="justify-content:space-between; flex-wrap: wrap; display: flex;">
                            <div class="Case-ID">
                                <img style="width:20px; height:20px;" class="casenum" alt="case" src="{{ asset('icon/cases.svg?v=1.0.0') }}">
                                <div class="refno">{!! $record->Case_ReferenceId !!}</div>
                            </div>
                            <div style="justify-content:flex-start; display:flex">
                                @if(!empty($record->Case_Opened))
                                <div class="Customer">
                                    <div class="datesec">
                                        <img style="width:20px; height:20px;" alt="date" src="{{ asset('icon/date.svg?v=1.0.0') }}">
                                        {!! optional($record->Case_Opened)->format("d/m/Y") !!}
                                    </div>

                                    <div class="datesec">
                                        <img style="width:20px; height:20px;" alt="clock" src="{{ asset('icon/clock.svg?v=1.0.0') }}">
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

                        <div class="Customer">
                            <img style="width:20px; height:20px;" alt="chome" src="{{ asset('icon/chome.svg?v=1.0.0') }}">
                            <div class="custname">{!! $record->Company->Comp_Name !!}</div>
                        </div>
                        @if(!empty( $record->case_mladdr ))
                        <div class="Customer">
                            <img style="width:20px; height:20px;" alt="case" src="{{ asset('icon/address.svg?v=1.0.0') }}">
                            <div class="contracttext">{!! $record->case_mladdr !!}</div>
                        </div>
                        @endif

                        @if(!empty($record->Contract))
                            @if($record->case_type == 'Adhoc')
                            <div class="Customer" style="justify-content:flex-start;">
                                <img style="width:20px; height:20px;" alt="contract" src="{{ asset('icon/contract.svg?v=1.0.0') }}">
                                <div class="contracttext">{!! optional($record->Contract)->ctra_Type!!}</div>
                                <div class="numofservicetext">No. of Service Calls : {!! optional($record->Contract)->ctra_numofsvcall !!}</div>
                            </div>
                            @elseif($record->case_type == 'Preventive')
                            <div class="Customer">
                                <img style="width:20px; height:20px;" alt="contract" src="{{ asset('icon/contract.svg?v=1.0.0') }}">
                                <div class="contracttext">{!! optional($record->Contract)->ctra_Type!!}</div>
                                <div class="numofservicetext">No. of PM : {!! optional($record->Contract)->ctra_numofpm!!}</div>
                            </div>
                            @endif
                        @endif
                        <div style="justify-content:space-between; display:flex;">
                            @if(!empty($record->Case_Description))
                            <div class="Customer">
                                <img style="width:20px; height:20px;" alt="case" src="{{ asset('icon/fault.svg?v=1.0.0') }}">
                                <div class="problemnote">{!! $record->Case_Description !!}</div>
                            </div>
                            @endif

                            @if(!empty($record->Person))
                            <div class="Customer">
                                <img style="width:20px; height:20px;" alt="pers" src="{{ asset('icon/person.svg?v=1.0.0') }}">
                                <div class="userfname"> {!! $record->User->User_FirstName !!} {!! $record->User->User_LastName !!} </div>
                            </div>
                            @endif
                        </div>

                        @if(!empty($record->Case_AssignedUserId))
                        <div class="Customer">
                            <img style="width:20px; height:20px;" alt="pers" src="{{ asset('icon/person.svg?v=1.0.0') }}">
                            <div class="userfname">{!! optional($record->Person)->Pers_FirstName !!} </div>
                        </div>
                        @endif
                    </div>

                </a>
                @endif
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
	$("#AcceptDatatable").DataTable({
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


$("#adhoc").on("click", function() {

	location.href="{!!route("cs.index")!!}"

});
$("#prevent").on("click", function() {

	location.href="{!!route("cs.prevent")!!}"

});
$("#accept").on("click", function() {

	location.href="{!!route("cs.accept")!!}"

});
$("#onhand").on("click", function() {

	location.href="{!!route("cs.onhand")!!}"

});

$("#project").on("click", function() {

location.href="{!!route("cs.project")!!}"

});

$("#cabling").on("click", function() {

location.href="{!!route("cs.cabling")!!}"

});

$("#service").on("click", function() {

location.href="{!!route("cs.service")!!}"

});



</script>
@endsection
