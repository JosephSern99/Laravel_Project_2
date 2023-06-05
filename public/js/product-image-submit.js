$(function(){
	$("#btn-image-remove").click(function(){
		$(".hidden-imgclear").remove();
		if(confirm("Remove Image? (This action cannot be undone.)")){
			$("#form-submit").append("<input type='hidden' class='hidden-imgclear' name='imgclear' value='Y' />");
			$("#form-submit").submit();
		}
	});
	
	$("#btn-submit").click(function(){
		$(".hidden-imgclear").remove();
		$("#form-submit").submit();
	});
	
	$("#fileimage").on("change", function(e){
		var files = $(this).prop("files");
		
		if (files && files[0]) {
			var f = files[0];
			
			var sz = (f.size || 0) / 1024 / 1024;
			
			if(sz > 5){
				alert("Your image had exceeded 5Mb, please reupload.");
				clearFileInput($(this));
			}else{
				var t =  f.type || "";
				
				if(t.indexOf("image") < 0){
					alert("Please upload image only.");
					clearFileInput($(this));
				}else{
					var reader = new FileReader();
					var reader_f = new FileReader();
					reader_f.readAsArrayBuffer(f);
					
					reader_f.onload = function(e){
						var view = new DataView(e.target.result), proceed = true, result = -1;
						if (view.getUint16(0, false) != 0xFFD8)
						{
							result = -2;
						}else{
							var length = view.byteLength, offset = 2;
							while (offset < length) 
							{
								if (view.getUint16(offset+2, false) <= 8){
									result = -1;
									break;
								}
								var marker = view.getUint16(offset, false);
								offset += 2;
								if (marker == 0xFFE1) 
								{
									if (view.getUint32(offset += 2, false) != 0x45786966) 
									{
										result = -1;
										break;
									}

									var little = view.getUint16(offset += 6, false) == 0x4949;
									offset += view.getUint32(offset + 4, little);
									var tags = view.getUint16(offset, little);
									offset += 2;
									for (var i = 0; i < tags; i++)
									{
										if (view.getUint16(offset + (i * 12), little) == 0x0112)
										{
											result = view.getUint16(offset + (i * 12) + 8, little);
											proceed = false; break;
										}
									}
									
									if(!proceed){
										break;
									}
								}
								else if ((marker & 0xFF00) != 0xFF00)
								{
									break;
								}
								else
								{ 
									offset += view.getUint16(offset, false);
								}
							}
						}
						
						var rt =  "rotate(0deg)";
						
						switch(result){
							case 2: rt = "scaleX(-1)";break;
							case 3: rt = "rotate(180deg)";break;
							case 4: rt = "scaleX(-1) rotate(180deg)";break;
							case 5: rt = "scaleX(-1) rotate(90deg)";break;
							case 6: rt = "rotate(90deg)";break;
							case 7: rt = "scaleX(-1) rotate(-90deg)";break;
							case 8: rt = "rotate(-90deg)";break;
							default: break;
						}
						
						$('#img-preview').css({"-ms-transform": rt, "-webkit-transform": rt, "-moz-transform": rt, "-o-transform": rt, "transform": rt});
					}
					
					reader.onload = function(e) {
						var img = new Image();
						img.src = e.target.result;
						img.onload = function(){
							var h = this.height;
							var w = this.width;
						}
						$('#img-preview').css('background-image', "url('" + e.target.result + "')");
					}
					
					
					reader.readAsDataURL(f);
				}
			}
		}else{
			clearFileInput($(this));
		}
	});
	
	function clearFileInput(x){
		x.val("");
		
		var customsrc = $('#img-preview').attr("customsrc") || "";
		
		var tImg = new Image();
		tImg.src = customsrc;
		
		tImg.onload = function(){
			$('#img-preview').css('background-image', "url('" + customsrc + "')");
		};
		
		tImg.onerror = function(){
			$('#img-preview').css('background-image', "url('" + img_nf + "')");
		}
	}
});
