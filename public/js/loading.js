$(function(){
	btnLoading();
});

function btnLoading(){
	var btn = $(".btn-loading");
	
	if(btn.length > 0){
		btn.click(function(){
			generateOverlay();
			showOverlay();
		});
	}
}

function generateOverlay(){
	if($("#loading-overlay").length === 0){
		var div_loading = "<div id='loading-overlay'><div id='loading-circle'></div></div>";
		$("body").append(div_loading);
	}
}

function hideOverlay(){
	$("#loading-overlay").hide();
}

function showOverlay(){
	if($("#loading-overlay").length === 0){
		generateOverlay();
	}
	$("#loading-overlay").show();
}