$(function(){
	$("#btn-search").on("click", function(){
		$("input.excel").remove();
		$(this).closest("form").trigger("submit");
	});
	
	$("#btn-excel").on("click", function(){
		$("input.excel").remove();
		var f = $(this).closest("form");
		f.append("<input type='hidden' name='excel' class='excel' value='Y' />");
		$("#hidden-form-submit").trigger("click");
	});
});