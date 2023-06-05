@extends('layouts.app')
@section('title', 'Items')

@section('content')

<link rel="stylesheet" href="{{ URL::asset('css/items1.css?v=1.2.7') }}">




<div class="link-class" style="justify-content: space-between; flex-wrap: wrap;
    justify-content: space-between;
    display: flex;">
    <div>
        <a href="{!!route("cs.checklistmain",["id"=>$record->getKey()])!!}"><img alt="Back" src="{{ asset('icon/back.svg?v=1.0.0') }}"></a>
        <span class="link-text">Back</span>
    </div>
    <div>
        <span class="link-text">Next</span>
        <a href="{!!route("cs.images",["id"=>$record->getKey()])!!}"><img alt="Next" src="{{ asset('icon/next.svg?v=1.0.0') }}"></a>
    </div>
</div>



<form method="POST" id="formid" action="{!!route("cs.itemssave",["id"=>$record->getKey()])!!}" >
@csrf

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
    height:calc(100vh - 300px);
    overflow-x: hidden;
    font-family: 'Mulish';
">

@foreach($products as $product)
<div class="items" >

    <input type="hidden" name="product[]" value="{!! $product->Prod_ProductID !!}">
    <input type="hidden" name="soitemid[]" value="{!! $product->svit_ServiceOrderItemID ?? 0 !!}">
    <input type="hidden" name="productname[]" value="{!!$product->prod_name!!}">
    <input type="hidden" class="unitprice" name="unitprice[]" value="{!! round($product->prod_UnitPriceSGD, 2) !!}">
    <div style="justify-content: flex-start; flex-wrap: wrap;
    display: flex;">
    <input type="checkbox" class="Checked-box checkboxes" {!! round($product->svit_quantity,2) > 0 ? "checked" : "" !!} checkboxid="{!! $product->Prod_ProductID !!}">
    <div class="div-item-green" style="margin-left:10px;">{!!$product->prod_name!!}</div>
    </div>

    <div style="justify-content: space-between; flex-wrap: wrap;
    display: flex;">
    <div class="quantity-btn" style="
    justify-content: flex-start;
    flex-wrap: wrap;
    display: flex;">
        <button type="button" class="minus" id="minus{!! $product->Prod_ProductID  !!}"><img alt="reduce" src="{{ asset('icon/minus.svg?v=1.0.0') }}" ></button>
        <input type="number" name="quantity[]"  class="quantitytext  quantity" value="{!! round($product->svit_quantity,2) !!}" id="quantity{!! $product->Prod_ProductID  !!}"/>
        <button type="button" class="add" id="add{!! $product->Prod_ProductID  !!}"><img alt="add" src="{{ asset('icon/plus.svg?v=1.0.0') }}"></button>
    </div>
    <div class="div-box" id="unitprice{!! $product->Prod_ProductID !!}"> <div class="div-text" style="font-size:16px"> ${!! number_format(round($product->prod_UnitPriceSGD, 2),2) !!} </div></div>
    </div>


</div>
@endforeach

</div>




<div class="total">
    <div style="display: flex;">
    <div class="labeltotal">Total </div>
    <input type="text"  class="total-price" id="totalprice" value="$0.00" name="totalprice" style="color: #265B55 !important; font-size:16px; border:none; width:50%; height:auto;" readonly/>
    <button type="button" id="proceed" name="proceed" class="btn-proceed"></button>
    </div>
</div>

</div>



</form>

@endsection
@section("script")

<script>


var totalunitprice=0;

//if click proceed check whether got value for 1 quantity of any item, if got proceed to do form method="methods"
$("#proceed").on("click", function(){
    let _hasValue = false;
    $(".quantity").each(function(){
        let _val = $(this).val() || 0;
        if(_val > 0){
        _hasValue = true;
        return true;
    }
    });



    //if got value only save record and proceed else require minimum 1 quantity.
    if(_hasValue){

        let _form = $("#formid");

        $.ajax(
            {
                url: _form.attr("action"),
                type: "POST",
                processData: false,
                contentType: false,
                data: new FormData(_form[0]),
                dataType: "JSON",
                success: function(data){
                location.href = "{!! route("cs.items2",["id"=>$id])!!}";
                },
                error: function(err){

                }

            }
        )


    }else{
        alert("Please select at least one item with quantity > 0.");
    }
});

$(".quantity").on("keyup", function(){
    calctotal();
});

$(function(){




$(".add").on("click", function(){
    let parent = $(this).closest(".items"); //find the parent class of checkbox
    let checkbox = parent.find(".checkboxes");
    let checkboxid = checkbox.attr("checkboxid");

    add(checkboxid);

    checkbox.prop('checked', true);

    calctotal();

    $(".checkboxes").each(function(){
        $(this).trigger("change");
    });

    // console.log(checkboxid);
});

$(".minus").on("click", function(){
    let parent = $(this).closest(".items"); //find the parent class of checkbox
    let checkbox = parent.find(".checkboxes");
    let checkboxid = checkbox.attr("checkboxid");

    minus(checkboxid);
    if($("#quantity"+checkboxid+"").val()==0){
        checkbox.prop('checked', false);
    }

    calctotal();

    $(".checkboxes").each(function(){
        $(this).trigger("change");
    });

    // console.log(checkboxid);
});



});


//on checkbox change function, have add and minus function bind to button add minus. If unchecked, set quantity value to 0.
$(".checkboxes").on("change", function() {
	let _this = $(this), _checkboxid = _this.attr("checkboxid") || "";
    // console.log(this.checked,_checkboxid);
	if(_checkboxid != "" && this.checked && $("#quantity"+_checkboxid+"").val()>0){
        // console.log(_checkboxid);
        // $("button#minus"+_checkboxid+"").attr("disabled", false);
        // $("button#minus"+_checkboxid+"").bind("click", minus);

        // $("button#add"+_checkboxid+"").attr("disabled", false);
        // $("button#add"+_checkboxid+"").bind("click", add);
        // $("#quantity"+_checkboxid+"").val(1);


    }
    else if(_checkboxid != ""  && this.checked  && $("#quantity"+_checkboxid+"").val()==0 ){
        $("#quantity"+_checkboxid+"").val(1);
    }

    else{

        $("#quantity"+_checkboxid+"").val(0);
        // var prodidstring = _checkboxid;
        // var upstr = $("#unitprice"+prodidstring+"").text();
        // var up = (upstr.split("$").pop());
        // // console.log(up);
        // if(totalunitprice > 0) {
        //     totalunitprice = Number(totalunitprice) - Number(up);
        //     $("#totalprice").val("$"+totalunitprice.toFixed(2));
        // }

    }

    //IF checked and unchecked, calculate total minus and deduct
    calctotal();

    //check how many check box is ticked
    var totalselected = $('input[type="checkbox"]:checked').length;
    totalcheckbox(totalselected);

});

//on each checkboxes trigger on change function
$(".checkboxes").each(function(){
    $(this).trigger("change");
});





//
function calctotal(){
    let total = 0; //initializing total
    $(".checkboxes:checked").each(function(){ //for each checkbox checked
        let parent = $(this).closest(".items"); //find the parent class of checkbox
        let quantity = parent.find(".quantity").val() || 0; //parent find child class of quantity
        let unitprice = parent.find(".unitprice").val() || 0; //parent find child class of unit price
        total += quantity * unitprice; //calc total price

    });
    // console.log(total);
    $(".total-price").val("$"+numberWithCommas(total.toFixed(2))); //summation of sub total price
    $("#proceed").attr("disabled",  $(".checkboxes:checked").length==0); // show to total price figure
}


function totalcheckbox(total){
    if(total > 0){
        $("#proceed").text("Save("+total+")");
    }else if(total == 0){
        $("#proceed").empty();
    }
    // console.log(total);

}



function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function minus(prodnum) {
    var quantitytotal = $("#quantity"+prodnum+"").val();
    if (quantitytotal > 0) // if quantity more than 0 then only minus
    {
        quantitytotal = Number(quantitytotal) - 1;
        $("#quantity"+prodnum+"").val(quantitytotal);
    }
    calctotal(); //calc total price
    // alert(quantitytotal);
}


function add(prodnum) {
    // var prodidstring = this.id;
    // var prodnum = (prodidstring.split("d").pop());

    var quantitytotal = $("#quantity"+prodnum+"").val();
    if (quantitytotal >= 0) // if quantity more than equals 0 then can plus
    {
        quantitytotal = Number(quantitytotal) + 1;
        $("#quantity"+prodnum+"").val(quantitytotal);
    }
    calctotal();


    // alert(quantitytotal);
}




</script>

@endsection
