@extends('layouts.app')
@section('title', __('table.moheader'))
@section('content')
<div class="container">
    <ul class="nav nav-tabs d-none" id="tab-mocreate" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="tab-step1" data-toggle="tab" href="#createStep1" role="tab" aria-controls="home" aria-selected="true">Step 1</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="tab-step2" data-toggle="tab" href="#createStep2" role="tab" aria-controls="profile" aria-selected="false">Step 2</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="tab-step3" data-toggle="tab" href="#createStep3" role="tab" aria-controls="messages" aria-selected="false">Step 3</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="createStep1" role="tabpanel" aria-labelledby="createStep1-tab">
            @include("testing.tab.create")
        </div>
        <div class="tab-pane fade" id="createStep2" role="tabpanel" aria-labelledby="createStep2-tab">
            @include("testing.tab.create2")
        </div>
        <div class="tab-pane fade" id="createStep3" role="tabpanel" aria-labelledby="createStep3-tab">
            @include("testing.tab.create3")
        </div>
    </div>
</div>
<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content border-0">
        <div class="modal-header bg-primary text-white">
            <h6 class="modal-title" id="productModalTitle"><span id="title-add">Add</span><span id="title-edit" class="d-none">Edit</span> Product</h6>
            <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group row">
                <div class="col-sm-6 mb-3" id="ssaProduct">
                    <label class="font-weight-bold" for="productid">{!! __("Product Code") !!}: </label>
                    <div class='input-group'>
                        <input type="text" placeholder="{!! __('Product Code') !!}" class="form-control input-ssa{{ $errors->has('productid') ? " is-invalid" : ""}}" id="productid_text" name="productid_text" value="{{ old("productid", 'invalid') !== 'invalid' ? (old("productid") == null ? '' : old("productid_text")) : (optional(optional($record ?? null)->productitem)->prit_name) }}" required/>
                        <input id="productid" name="productid" class="hidden-ssa" type="hidden" value="{{ old("productid", optional($record ?? null)->productid) }}" />
                        <div class="input-group-append"><span class="input-group-text search-ssa"><i class="fa fa-search"></i></span></div>
                        @if($errors->has('productid'))
                        <div class="invalid-feedback">
                            {{$errors->first("productid")}}
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6 mb-3">
                    <label class="font-weight-bold" for="productDescription">{!! __("Description") !!}: </label>
                    <div id="productDescription"></div>
                </div>
                <div class="col-sm-6 mb-3">
                    <label class="font-weight-bold" for="productQtyOnHand">{!! __("Qty On Hand") !!}: </label>
                    <div id="productQtyOnHand"></div>
                </div>
                <div class="col-sm-6 mb-3">
                    <label class="font-weight-bold" for="productQtyUsed"><span id="spanQtyUsed">{!! __("Qty Used") !!}</span><span id="spanQtyProduced" class="d-none">{!! __("Qty Produced") !!}</span>: </label>
                    <input id="productQtyUsed" class="form-control text-right" type="text" />
                </div>
                <input id="productbomheaderid" class="form-control text-right" type="hidden" />
                <input id="productbomdetailid" class="form-control text-right" type="hidden" />
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" type="button" id="btnModalAdd"><span id="btn-add">{!! __('label.add') !!}</span><span id="btn-edit" class="d-none">{!! __('label.edit') !!}</span></button>
            <button class="btn btn-teal" type="button" data-dismiss="modal">{!! __('label.cancel') !!}</button>
        </div>
    </div>
    </div>
</div>
@endsection
@section('script')
<script src="{!! route("javascript.ssa", ["u" => "ajax-ssa"]) !!}"></script>
<script>
$(function(){
    $("#btnStep1to2").on("click", function(){
        //need set session to Step 2
        $("#tab-step2").trigger("click");
    });
    $("#btnStep2to1").on("click", function(){
        //need set session to Step 1
        $("#tab-step1").trigger("click");
    });
    $("#btnStep2to3").on("click", function(){
        //need set session to Step 3
        $("#tab-step3").trigger("click");
    });
    $("#btnStep3to2").on("click", function(){
        //need set session to Step 2
        $("#tab-step2").trigger("click");
    });

    var counter = -1;

    var ssaOptions = {
        connection: "accpac",
        model: 'ICITEM',
        column: ["ITEMNO", "DESC"],
        caption: "ITEMNO",
        value: "ITEMNO",
        where: "ITEMNO IN (SELECT ITEMNO FROM ICILOC WHERE [LOCATION] = '{!! config("custom.DB_ACCPAC_LOCATION") !!}') AND CATEGORY IN (SELECT CATEGORY FROM ICCATG WHERE INACTIVE != '1')"
    };
    $("#ssaProduct").SetSSA(ssaOptions);

    $("#productid").on("change", function(){
        var _id = $(this).val();

        if(_id){
            $.ajax({
                url: "{!! route("product.info") !!}",
                type: "post",
                dataType: "json",
                data: {
                    "id" : _id
                },
                success: function(_data){
                    var description = _data.description || "", qtyonhand = _data.qtyonhand || 0;
                    $("#productDescription").text(description);
                    $("#productQtyOnHand").text(parseFloat(qtyonhand).toFixed(2));
                    $("#productQtyUsed").trigger("change");
                },error: function(xhr, stt, st){
                    alert("Error when get Product Info");
                }
            });
        }
    });

    $("#productQtyUsed").on("change", function(){
        var _t = $(this), _v = _t.val() || 0;

        if(isNaN(_v)){
            _v = 0;
        }
        var _qtyonhand = $("#productQtyOnHand").text() || 0;
        if(isNaN(_qtyonhand)){
            _qtyonhand = 0;
        }
        _qtyonhand = parseFloat(_qtyonhand);
        _v = parseFloat(_v);

        _t.val(Math.max(0,Math.min(_v, _qtyonhand)));
    });

    $("#product-tbody").on("change", ".product-qtyused", function(){
        var _t = $(this), _v = _t.val() || 0;

        if(isNaN(_v)){
            _v = 0;
        }
        var _qtyonhand = _t.closest("tr").find(".product-qtyonhand").val() || 0;
        if(isNaN(_qtyonhand)){
            _qtyonhand = 0;
        }
        _qtyonhand = parseFloat(_qtyonhand);
        _v = parseFloat(_v);

        _t.val(Math.max(0,Math.min(_v, _qtyonhand)));
    });

    $("#product-tbody").on("click", ".btnDelete", function(){
        if(confirm("Delete Item?")){
            var _tr = $(this).closest("tr"), _detailid = _tr.find(".detailid").val() || "0";

            if(_detailid != "0"){
                removeLinkedTR(_detailid);
            }

            _tr.remove();
        }
    });

    function removeLinkedTR(detailid){
        if(detailid != "0"){
            var _tr = $(".refdetailid[value='" + detailid + "']").closest("tr");

            if(_tr.length > 0){
                var _detailid = _tr.find(".detailid").val() || "0";
                if(_detailid != "0"){
                    removeLinkedTR(_detailid);
                }
            }
            _tr.remove();
        }
    }

    $("#productModal").on("show.bs.modal", function(){
        var _isEdit = $("tr.modal-target").length > 0;

        if(_isEdit){
            $("#title-add, #btn-add").addClass("d-none");
            $("#title-edit, #btn-edit").removeClass("d-none");
        }else{
            $("#title-add, #btn-add").removeClass("d-none");
            $("#title-edit, #btn-edit").addClass("d-none");
        }
    });

    $("#productModal").on("hide.bs.modal", function(){
        var _modal = $("#productModal");
        _modal.find("#productid").val("");
        _modal.find("#productid_text").removeClass("ssa-set").val("");
        _modal.find("#productDescription").text("");
        _modal.find("#productQtyOnHand").text("");
        _modal.find("#productQtyUsed").val(0);
        _modal.find("#productbomheaderid").val("");
        _modal.find("#productbomdetailid").val("");

        $("tr.modal-target").removeClass("modal-target");
        $("#btnModalAdd").prop("disabled", false);
    });

    $("#btnAddItem").on("click", function(){
        var _modal =  $("#productModal");
        if($(this).hasClass("btn-step1")){
            $("#spanQtyUsed").removeClass("d-none");
            $("#spanQtyProduced").addClass("d-none");
        }else{
            $("#spanQtyUsed").addClass("d-none");
            $("#spanQtyProduced").removeClass("d-none");
        }

        _modal.modal();
    });

    $("#product-tbody").on("click", ".btn-modal", function(e){
        e.preventDefault();

        var _t = $(this), _id = _t.attr("data-id") || "0", _tr = _t.closest("tr");

        var _modal =  $("#productModal");

        _modal.find("#productid").val(_tr.find(".product-id").val() || 0);
        _modal.find("#productid_text").val(_tr.find(".product-code").val() || "").addClass("ssa-set");
        _modal.find("#productDescription").html(_tr.find(".product-description").val() || "");
        _modal.find("#productQtyOnHand").html(_tr.find(".product-qtyonhand").val() || "");
        _modal.find("#productQtyUsed").val(_tr.find(".product-qtyused").val() || "");
        _modal.find("#productbomheaderid").html(_tr.find(".bomheaderid").val() || "");
        _modal.find("#productbomdetailid").val(_tr.find(".bomdetailid").val() || "");

        _tr.addClass("modal-target");
        _modal.modal();
    });

    $("#btnModalAdd").on("click", function(){
        var _modal = $("#productModal");
        var _productid = _modal.find("#productid").val() || "", _code = $.trim(_modal.find("#productid_text").val() || ""), _desc =  _modal.find("#productDescription").text() || "";
        var _qtyonhand = _modal.find("#productQtyOnHand").text() || 0, _qtyUsed = _modal.find("#productQtyUsed").val() || 0;

        if(_productid == ""){
            alert("Please select an Item.");
        }else{
            var _tr = $("tr.modal-target"), searchLinkedItem = true;

            if(_tr.length == 0){
                _tr = $("<tr>").append(
                    $("<td>").attr("scope", "row").append(
                        $("<a>").attr({"href": "#", "data-id": "0"}).addClass("btn-modal edit").append(
                            $("<span>").addClass("span-product-code").text(_code)
                        )
                    ).append(hiddenInput().addClass("detailid").val(counter))
                    .append(hiddenInput().addClass("product-code").val(_code))
                    .append(hiddenInput().addClass("product-id").val(_productid))
                    .append(hiddenInput().addClass("refdetailid").val(0))
                    .append(hiddenInput().addClass("bomheaderid").val(0))
                    .append(hiddenInput().addClass("bomdetailid").val(0))
                ).append(
                    $("<td>").attr("scope", "row").append(
                        $("<span>").addClass("span-product-description").text(_desc)
                    ).append(hiddenInput().addClass("product-description").val(_desc))
                ).append(
                    $("<td>").attr("scope", "row").addClass("text-right").append(
                        $("<span>").addClass("span-product-qtyonhand").text(_qtyonhand)
                    ).append(hiddenInput().addClass("product-qtyonhand").val(_qtyonhand))
                ).append(
                    $("<td>").attr("scope", "row").addClass("text-right").append(
                        $("<input>").attr("type", "text").addClass("form-control form-control-sm product-qtyused text-right").val(_qtyUsed)
                    )
                ).append(
                    $("<td>").attr("scope", "row").addClass("text-right")
                        .append($("<button>").attr("type", "button").addClass("btn btn-danger btnDelete").append($("<i>").addClass("fas fa-trash")))
                );

                $("#product-tbody").append(_tr);

                counter--;
            }else{
                var currentProductCode = _tr.find(".span-product-code").text();
                if(currentProductCode == _code){
                    searchLinkedItem = false;
                }

                _tr.find(".span-product-code").text(_code);
                _tr.find(".product-code").val(_code);
                _tr.find(".product-id").val(_productid);

                _tr.find(".span-product-description").text(_desc);
                _tr.find(".product-description").val(_desc);

                _tr.find(".span-product-qtyonhand").text(_qtyonhand);
                _tr.find(".product-qtyonhand").val(_qtyonhand);

                _tr.find(".product-qtyused").val(_qtyUsed);
            }

            if(searchLinkedItem){
                $.ajax({
                    url: "{!! route("bomd.info") !!}",
                    type: "post",
                    dataType: "json",
                    data: {"itemno": _code},
                    success: function(_data){
                        if(_data.status == "ok"){
                            var refDetailId = _tr.find(".detailid").val() || 0;
                            removeLinkedTR(refDetailId);
                            _tr.find(".bomheaderid").val(_data.bomheaderid || 0);
                            _tr.find(".bomdetailid").val(_data.bomdetailid || 0);

                            var _subitems = _data.subitems || [];

                            generateExtraItem(_subitems, refDetailId, 0);
                            $("#productModal").modal("hide");
                        }else{
                            $("#productModal").modal("hide");
                        }
                    }, error: function(_data){
                        alert("Error on looking BOM Details");
                        $("#productModal").modal("hide");
                    }
                });
            }else{
                $("#productModal").modal("hide");
            }
        }
    });

    function generateExtraItem(_subitems, _refdetailid, _level){
        var _subitemsLength = _subitems.length;
        _level++;

        var refTR = $("#product-tbody").find(".detailid[value='" + _refdetailid + "']").closest("tr");

        for(var s = 0; s < _subitemsLength; s++){
            var _subitemObj = _subitems[s];

            var _tr = $("<tr>").append(
                $("<td>").attr("scope", "row").append(function(){
                    var arrow = "";
                    for(var i = 0; i < _level; i++){
                        arrow += "<i class='fas fa-caret-right'></i>";
                    }
                    return arrow;
                })
                .append(
                    $("<span>").addClass("span-product-code").text(_subitemObj.itemno || "")
                ).append(hiddenInput().addClass("detailid").val(counter))
                .append(hiddenInput().addClass("product-code").val(_subitemObj.itemno || ""))
                .append(hiddenInput().addClass("product-id").val(_subitemObj.itemno || ""))
                .append(hiddenInput().addClass("refdetailid").val(_refdetailid || 0))
                .append(hiddenInput().addClass("bomheaderid").val(_subitemObj.bomheaderid || 0))
                .append(hiddenInput().addClass("bomdetailid").val(_subitemObj.bomdetailid || 0))
            ).append(
                $("<td>").attr("scope", "row").append(
                    $("<span>").addClass("span-product-description").text(_subitemObj.description || "")
                ).append(hiddenInput().addClass("product-description").val(_subitemObj.description || ""))
            ).append(
                $("<td>").attr("scope", "row").addClass("text-right").append(
                    $("<span>").addClass("span-product-qtyonhand").text(_subitemObj.qtyonhand || "0")
                ).append(hiddenInput().addClass("product-qtyonhand").val(_subitemObj.qtyonhand || "0"))
            ).append(
                $("<td>").attr("scope", "row").addClass("text-right").append(
                    $("<input>").attr("type", "text").addClass("form-control form-control-sm product-qtyused text-right").val(_subitemObj.qtyused || "0")
                )
            ).append(
                $("<td>").attr("scope", "row").addClass("text-right")
                    .append($("<button>").attr("type", "button").addClass("btn btn-danger btnDelete").append($("<i>").addClass("fas fa-trash")))
            );

            refTR.after(_tr);
            counter--;

            var subitems = _subitemObj["subitems"] || [];
            generateExtraItem(subitems, _tr.find(".detailid").val() || 0, _level);
        }
    }

    function hiddenInput(){
        return $("<input>").attr("type", "hidden");
    }
});
</script>
@endsection
