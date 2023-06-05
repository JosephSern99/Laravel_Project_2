@extends('layouts.app')
@section('title', 'Signature')

@section('content')

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/themes/smoothness/jquery-ui.css" rel="stylesheet"/>

<div id="dialog-confirm"></div>

<link rel="stylesheet" href="{{ URL::asset('css/signature.css?v=1.0.2') }}">


<div class="link-class" style="justify-content: space-between; flex-wrap: wrap;
    justify-content: space-between;
    display: flex;">
    <div>
        <a href="{!!route("cs.checklistmain",["id"=>$record->getKey()])!!}"><img alt="Back" src="{{ asset('icon/back.svg?v=1.0.0') }}"></a>
        <span class="link-text">Back</span>
    </div>
</div>

<div class="cards-default">
    <div class="div-box" style="justify-content:space-between; display:flex; flex-wrap:wrap;">
        <div style="justify-content:space-between; display:flex;">
            <img style="width:15px; height:15px;" alt="cases" src="{{ asset('icon/caselist.svg?v=1.0.0') }}">
            <div class="div-text-green">{!! $record->Case_ReferenceId !!}</div>
        </div>
        <div class="div-text-green">Total amount : $ {!! $totalamount !!}</div>
    </div>
    @if(!empty($record->ServiceOrder->svor_RefNo))
        <div class="div-box">
            <img style="width:15px; height:15px;" alt="person" src="{{ asset('icon/person.svg?v=1.0.0') }}">
            <div class="div-text">{!! optional($record->ServiceOrder)->svor_RefNo !!}</div>
        </div>
    @endif
    <div class="div-box">
        <img style="width:15px; height:15px;" alt="date" src="{{ asset('icon/date.svg?v=1.0.0') }}">
        <div class="div-text">{!! optional($record->ServiceOrder)->svor_ServiceOrderDate->format("d/m/Y") !!} </div>
    </div>
    <div class="div-box">
        <img style="width:15px; height:15px;" alt="customer" src="{{ asset('icon/chome.svg?v=1.0.0') }}">
        <div class="div-text"> {!! $record->Company->Comp_Name !!} </div>
    </div>
</div>

<div class="cards-default">
    <div class="div-text">Signature*</div>
    <div class="div-sign-box" style="justify-content: space-between; flex-wrap: wrap;
    justify-content: space-between;
    display: flex;">
        <img style="width:60px; height:50px;" id="sign">
        <a href="#" data-toggle="modal" data-target="#signaturemodal"><img alt="edit"  src="{{ asset('icon/signaturepen.svg?v=1.0.0') }}"></a>

    </div>

    <div class="div-text">Name*</div>
    <input type="text"  class="text-field" value="{!! $record->ServiceOrder->svor_signname  ?? null !!}" id="svor_signname"/>

    <div class="div-text">Designation</div>
    <input type="text"  class="text-field" value="{!! $record->ServiceOrder->svor_signdesignation ?? null !!}" id="svor_signdesignation"/>

    <div class="div-text">Email*</div>
    <input type="text"  class="text-field" value="{!! $record->ServiceOrder->svor_signemail ?? null !!}" id="svor_signemail"/>

    <div class="div-text">Phone*</div>
    <input type="text"  class="text-field" value="{!! $record->ServiceOrder->svor_signcontactnum  ?? null !!}" id="svor_signcontactnum"/>

    <div class="div-text">CC</div>
    <input type="text"  class="text-field" value="{!! $record->ServiceOrder->svor_signcc  ?? null !!}" id="svor_signcc"/>


    <div class="sheet-container" style="justify-content: flex-start;">
        <button id="clear" class="Secondary-btn">
            <span class="button">Clear</span>
            <img alt="erase" src="{{ asset('icon/erase.svg?v=1.0.0') }}"/>
        </button>

        <button id="preview" class="Secondary-btn" data-toggle="modal" data-target="#breakdownmodal">
            <span class="button">Preview</span>
            <img alt="preview" src="{{ asset('icon/caselist.svg?v=1.0.0') }}"/>
        </button>

        <button id="finish" class="Primary-btn">
            <span class="buttonsave">Save</span>
            <img alt="save" src="{{ asset('icon/save.svg?v=1.0.0') }}"/>
        </button>
    </div>



    <div class="modal fade" id="breakdownmodal" tabindex="2" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body" style="font-family: 'Mulish' !important; max-height: calc(100vh - 100px);">
                    <div style="
                        width:auto;
                        overflow-y: auto;
                        overflow-x: hidden;
                        font-family: 'Mulish';
                        max-height: calc(100vh - 250px);
                    ">

                        @foreach($items as $item)
                        <div class="items">

                            <div class="item-name">{!!$item->svit_Name!!}</div>
                                <div class="div-box" style="justify-content: space-between; flex-wrap: wrap;
                                display: flex;">
                                    <div class="div-text" style="font-size:12px;">Quantity: </div>
                                    <div class="div-text" style="font-size:12px;">{!! number_format($item->svit_quantity) !!}</div>
                                </div>
                                <div class="div-box" style="justify-content: space-between; flex-wrap: wrap;
                                display: flex;">
                                    <div class="div-text" style="font-size:12px;">Unit Price:</div>
                                    <div class="div-text" style="font-size:12px;">$ {!! number_format(round($item->svit_unitprice, 2),2) !!}</div>
                                </div>

                                <div class="div-box" style="justify-content: space-between; flex-wrap: wrap;
                                display: flex;">
                                    <div class="div-text-green" style="font-size:12px;">Subtotal:</div>
                                    <div class="div-text-green" style="font-size:12px;">$ {!! number_format(round($item->svit_pricetotal, 2),2) !!}</div>
                                </div>
                        </div>


                        @endforeach

                    </div>

                    <div class="items">
                        @if(!empty($checkin))
                        <div class="div-box" style="justify-content: space-between; flex-wrap: wrap;
                            display: flex;">
                                <div class="div-text" style="font-size:12px;">Check In: </div>
                                <div class="div-text" style="font-size:12px;">{!! $checkin->format("d/m/Y H:i:s") !!}</div>
                        </div>
                        @endif
                        @if(!empty($checkout))
                        <div class="div-box" style="justify-content: space-between; flex-wrap: wrap;
                            display: flex;">
                                <div class="div-text" style="font-size:12px;">Check Out: </div>
                                <div class="div-text" style="font-size:12px;">{!! $checkout->format("d/m/Y H:i:s") !!}</div>
                        </div>
                        @endif
                        @if(!empty($paidamount))
                        <div class="div-box" style="justify-content: space-between; flex-wrap: wrap;
                            display: flex;">
                                <div class="div-text" style="font-size:12px;">Total Labour Charge: </div>
                                <div class="div-text" style="font-size:12px;"> $ {!! number_format(round($paidamount,2),2) !!}</div>
                        </div>
                        @endif
                        @if(!empty($totalitemamount))
                        <div class="div-box" style="justify-content: space-between; flex-wrap: wrap;
                            display: flex;">
                                <div class="div-text" style="font-size:12px;">Total Item Charge: </div>
                                <div class="div-text" style="font-size:12px;"> $ {!! number_format(round($totalitemamount, 2),2) !!}</div>
                        </div>
                        @endif
                        @if(!empty($totalamount))
                        <div class="div-box" style="justify-content: space-between; flex-wrap: wrap;
                            display: flex;">
                                <div class="div-text" style="font-size:12px;">Total Charge: </div>
                                <div class="div-text" style="font-size:12px;"> $ {!! number_format(round($totalamount,2),2) !!}</div>
                        </div>
                        @endif
                    </div>



                </div>
                <!-- <div class="modal-footer">
                </div> -->

            </div>
        </div>
    </div>


    <div class="modal fade" id="signaturemodal" tabindex="1" role="dialog" aria-hidden="true">


        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <!-- <div class="modal-body" style="font-family: 'Mulish' !important;">{!! __('message.logoutconfirmation') !!}</div> -->
            <div class="modal-footer justify-content-center">
                <div id="signature">

                </div>
            </div>
            <div class="btn-container">
                <button id="erasecanvas" class="erase-btn">
                    <img alt="erase" style="width:14.2px; height:14.2px;" src="{{ asset('icon/erase.svg?v=1.0.0') }}"/>
                </button>
                <button id="savecanvas" class="save-btn">
                    <img alt="erase" style="width:18px; height:18px;" src="{{ asset('icon/save.svg?v=1.0.0') }}"/>
                </button>
            </div>
        </div>
        </div>
    </div>


</div>

@endsection
@section('script')

<script>
	var sign = "{!! $record->ServiceOrder->svor_sign !!}";

    var paidamount =  "{!! $paidamount !!}"


	$(function(){

    $("#sign").css("visibility","hidden");

	$("#clear").on("click", function() {
		document.getElementById("svor_signname").value = "";
		document.getElementById("svor_signdesignation").value = "";
		document.getElementById("svor_signemail").value = "";
		document.getElementById("svor_signcontactnum").value = "";
		document.getElementById("svor_signcc").value = "";
        // document.getElementById("sign").src = "";
        $("#sign").css("visibility","hidden");

		}


	);


    $("#erasecanvas").on("click", function() {
        const context = canvas.getContext('2d');
		context.clearRect(0, 0, canvas.width, canvas.height);

    });

    $("#savecanvas").on("click", function() {
        var Pic = document.getElementById("canvas").toDataURL("image/png",1);
        Pic = Pic.replace(/^data:image\/(png|jpg);base64,/, "");

        $("#sign").attr("src","data:image/svg;base64,"+Pic+"");
        $("#sign").css("visibility","visible");
        $('#signaturemodal .close').click();

    });


    $("#signature").append('<div id="dvSign" style="width: 100%; height: 100%;">' +
		'<canvas id="canvas" width="310" height="155.98"></canvas></div>');
		var canvas = document.getElementById("canvas");
		var signaturePad = new SignaturePad(canvas,{
				backgroundColor : "rgb(255,255,255)"
    });


	if(sign!=""){
        $("#sign").css("visibility","visible");
		$("#sign").attr("src",""+sign+"");
	}




	$("#finish").on("click", function() {
			var Pic = $("#sign").attr('src');
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
            });

			$.ajax({
				url: "{!!route("cs.finish",["id"=>$record->getKey()])!!}",
				type: "post", //or get
				data: {
					Pic: Pic,
					"name":$("#svor_signname").val(),
					"Svor_Signdesignation":$("#svor_signdesignation").val(),
					"email":$("#svor_signemail").val(),
					"phone":$("#svor_signcontactnum").val(),
					"cc":$("#svor_signcc").val(),
					"user": "{{ auth()->user()->User_Logon }}",
                    "paidamount":paidamount


				},
				dataType: "json", //if the returned values need to be in json format
				success: function(_data){

                    if(_data.errors){
                        alert(_data.errors);
                        return false;
                    }
					alert("Service Order Completed");
					// var complete=confirm("Is this Case Closed?");

                    $("#dialog-confirm").dialog({
                        dialogClass: 'no-close',
                        modal: true,
                        title: 'Case Closed?',
                        zIndex: 10000,
                        autoOpen: true,
                        width: '250px',
                        resizable: false,
                        buttons: {
                        "No": {
                            text: "No",
                            class: "button-no leftButton",
                            click: function() {

                            // $(this).dialog('close');
                            $.ajax({
                            url: "{!!route("cs.notclose",["id"=>$record->getKey()])!!}",
                            type: "POST", //or get
                            data: {

                            },
                            success: function(_data){

                            }, //what to do if success
                            error: function(_xhr, _stt, _st){

                            alert("Error on Signing");

                            }, //what to do if error
                            complete: function(){
                                location.href="{!!route("cs.accept")!!}"

                            } //what to do if complete (either success or error)
                            });

                            }
                        },
                        "Yes": {
                                    text: "Yes",
                                    class: "button-yes",
                                    click: function() {

                                        // $(this).dialog('close');
                                        $.ajax({
                                        url: "{!!route("cs.close",["id"=>$record->getKey()])!!}",
                                        type: "POST", //or get
                                        data: {

                                        },
                                        success: function(_data){

                                        }, //what to do if success
                                        error: function(_xhr, _stt, _st){

                                        alert("Error on Signing");

                                        }, //what to do if error
                                        complete: function(){
                                            location.href="{!!route("cs.accept")!!}"

                                        } //what to do if complete (either success or error)
                                        });

                                    }
                            }
                        }
                    });

				}, //what to do if success
				error: function(_xhr, _stt, _st){

				}, //what to do if error
				complete: function(){


				} //what to do if complete (either success or error)
			});

		});



 });

</script>
@endsection
