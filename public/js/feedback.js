$(function(){
	checkfeedbacktype();
	
	$("#fdbk_subject").on("change", function(){
		checkfeedbacktype();
	});
	
	$("#fdbk_upload").on("change", function(){
		var files = $(this).prop("files");
		
		if (files && files[0]) {
			var f = files[0];
			
			var sz = (f.size || 0) / 1024 / 1024;
			
			if(sz > 5){
				alert("Your files had exceeded 5Mb, please reupload.");
				$("#fdbk_upload").val("");
				$("#lbl_upload").text("Choose file");
			}else{
				var t =  f.name || "";
				$("#lbl_upload").text(t);
			}
		}else{
			$("#lbl_upload").text("Choose file");
		}
		
	});
});

function checkfeedbacktype(){
	var field = $("#fdbk_subject");
	
	if(field.length > 0){
		var value = field.val() || "";
		//$("#fdbk_companyid").prop("disabled", value != "2");
	}
}