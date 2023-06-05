@extends('layouts.app')
@section('title', __('Information'))
@section('content')
<link rel="stylesheet" href="{{ URL::asset('css/equipmentlist.css?v=1.0.1') }}">
<div class="sheet-container">
    <button class="ActionsService" id="service"><div class="Service">Service Orders</div>
        <img class="CompassService" alt="ServiceLogo" src="{{ asset('icon/service-black.svg?v=1.0.0') }}">
    </button>

    <button class="ActionsEquipment" id="equipment"><div class="Equipment">Equipment List</div>
        <img class="CompassEquipment" alt="EquipmentLogo" src="{{ asset('icon/equipment-green.svg?v=1.0.0') }}">
    </button>
</div>


<div class="Cases container-fluid p-0" style="height:calc(100vh - 245px);">
    <table class="dataTables_wrapper" id="EquipmentDatatable">
        <thead class="bg-primary text-white" style="display:none;">
            <tr>
                <th>@lang("Case")</th>
            </tr>
        </thead>
        <tbody>
                <!-- @foreach($records as $record)
                <tr>
                    <td scope="row">

                        <div class="info-card">

                        </div>

                    </td>
                </tr>
                @endforeach -->
        </tbody>
    </table>
</div>

@endsection

@section('script')
<script>
$(function(){
	var table = $("#EquipmentDatatable").DataTable({
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
