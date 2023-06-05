$(function(){
	var dtable = $('#recordTable').DataTable({
		responsive: true,
		columnDefs: [ 
		{ responsivePriority: 1, targets: 0},
		{ responsivePriority: 4, targets: 3},
		{ responsivePriority: 3, targets: 4},
		{ orderable: false, responsivePriority: 2, targets: 5}
		],
		"fnDrawCallback": function(x) {
			$(this).find(".checkbox_product, #chkall").prop("checked", false);
		}
	});
	
	$("#recordTable").on("change", "#chkall", function(){
		var c = $(this).prop("checked");
		
		if(c){
			$("#recordTable").find(".checkbox_product:not(:checked)").prop("checked", true);
		}else{
			$("#recordTable").find(".checkbox_product:checked").prop("checked", false);
		}
	}).on("change", ".checkbox_product", function(){
		var c = $(this).prop("checked");
		var c_all = $("#chkall");
		var c_total = $("#recordTable").find(".checkbox_product").length;
		var c_check = $("#recordTable").find(".checkbox_product:checked").length;
		if(c){
			if(c_total == c_check){
				c_all.prop("checked", true);
			}
		}else{
			c_all.prop("checked", false)
		}
	});
	
	
	$(".btn-submit").on("click", function(){
		$(".product_submit").remove();
		var btnValue = $(this).val() || "";
		
		if(btnValue != "Approve" && btnValue != "Reject"){
			$("#errorModal_body").text("Unknown error occured.");
			$("#errorModal").modal();
		}else{
			if($("#recordTable").find(".checkbox_product:checked").length){
				$("#recordTable").find(".checkbox_product:checked").each(function(){
					var v = $(this).closest("td").find(".hidden_value");
					var v_get = v.length ? (v.val() || "") : "";
					if(v_get != ""){
						$("#form-submit").append("<input class='product_submit' name='productlist[]' type='hidden' value='" + v_get + "' />");
					}
				});
				if(confirm(btnValue == "Approve" ? "Approve?" : "Reject?")){
					$("#form-submit").append("<input class='product_submit' name='method' type='hidden' value='" + (btnValue == "Approve" ? "a" : "r" ) + "' />");
					$("#submitModal").modal({backdrop: 'static', keyboard: false});
					$("#form-submit").submit();
				}
			}else{
				$("#errorModal_body").text("Please select product.");
				$("#errorModal").modal();
			}
		}
	});
});