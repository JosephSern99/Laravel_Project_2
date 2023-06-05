
$(function(){
    $("#chkAll").on("change", function(){
        $(".checkbox").prop("checked", $(this).prop("checked"));
    });

    $(".checkbox").on("change", function(){
        $("#chkAll").prop("checked", $(".checkbox").length === $(".checkbox:checked").length);
    });

    $("#bomh_morequiredtemperature, #bomh_morequiredtimeduration, #bomh_shelflife").on("change", function(){
        var _t = $(this), _v = _t.val() || "";

        if(isNaN(_v)){
            _v = 0;
            _t.val(_v);
        }
    });

    $("#btnSave").on("click", function(){
        var checked = $(".checkbox:checked");

        if(!$("#frmSubmit").hasClass("inprogress")){
            if(checked.length === 0){
                alert("Please select at least one item.");
            }else{
                if(confirm("Create Manufacture Order?")){
                    $("#frmSubmit").addClass("inprogress");
                    checked.each(function(){
                        var _t = $(this), _v = _t.val() || 0, _tr = _t.closest("tr");

                        $("#frmSubmit").append($("<input>").attr({"type" : "hidden", "name" : "bomid[]"}).val(_v));
                        $("#frmSubmit").append($("<input>").attr({"type" : "hidden", "name" : "bomh_morequiredtemperature[]"}).val(_tr.find(".bomh_morequiredtemperature").val() || ""));
                        $("#frmSubmit").append($("<input>").attr({"type" : "hidden", "name" : "bomh_morequiredtimeduration[]"}).val(_tr.find(".bomh_morequiredtimeduration").val() || ""));
                        $("#frmSubmit").append($("<input>").attr({"type" : "hidden", "name" : "bomh_shelflife[]"}).val(_tr.find(".bomh_shelflife").val() || ""));
                    });
                }
                $("#frmSubmit").submit();
            }
        }
    });
});
