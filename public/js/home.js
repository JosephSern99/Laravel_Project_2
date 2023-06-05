var dtp_option = {format: "YYYY-MM-DD"};
var dtp_option2 = {format: "YYYY-MM-DD HH:mm:ss"};
var DT_option = {responsive: true};
var _baseURL = "/econdev";

$(function(){
    $("#btn-spv").click(function(){
        $("#form-spv").submit();
    });

	$(".product-popup").click(function(){
		var _this = $(this), _parent = _this.closest(".productdata");
		var _modal = $("#productInfoModal");

		var modalInfoParent = $("#modalInfo");
		var _uom = $(this).find(".productuom").text();

		modalInfoParent.find(".product-image").attr("src", $(this).find(".showimage").attr("src"));
		modalInfoParent.find(".product-description").text($(this).find(".description").text());
		modalInfoParent.find(".product-supplier").text($(this).find(".supplier_span").text());
		modalInfoParent.find(".product-remarks").html($(this).find(".remark_span").text().replace(/(?:\r\n|\r|\n)/g, '<br>'));
		modalInfoParent.find(".product-uom").text(_uom);
		modalInfoParent.find(".product-unitprice").text($(this).find(".productprice").text());
		modalInfoParent.find(".product-category").text($(this).find(".productcat").val());

		var _currencyUnit = _parent.find(".productcurrency").text();

		var _modalExtra = modalInfoParent.find(".div-extra");
		_modalExtra.html("").hide();

		$.ajax({
			url: _baseURL + "/iteminfo",
			data: {
				"productid" : _parent.attr("productid"),
				"companyid" : _parent.attr("supplierid")
			},
			type: "post",
			success: function(_data){
				var _price = _data.pricing || [], _foc = _data.foc || [];
				var _priceLength = _price.length, _focLength = _foc.length;
				var _priceExpand = false;
				if(_priceLength > 0){
					for(var _p = 0; _p < _priceLength; _p++){
						if(_p > 0){
							var p = _price[_p], _qty = parseInt(p.qty || 0, 10);
							
							if(_qty > 1){
								_priceExpand = true;
						_modalExtra.append($("<div>").text("Buy " + (p.qty || 0) + " to get Price of " + _currencyUnit + " " + (p.price || 0) + " per " + (_uom || "unit") + "."));
					}
				}
					}
				}

				if(_focLength > 0){
					if(_modalExtra.html() != ""){
						_modalExtra.append($("<br/>"));
					}
					for(var _f = 0; _f < _focLength; _f++){
						var p = _foc[_f];
						_modalExtra.append($("<div>").text("Buy " + (p.qty || 0) + " to get " + (p.foc || 0) + " free."));
					}
				}
				
				if(_focLength > 0 || _priceExpand){
					_modal.find(".modal-dialog").addClass("modal-lg");
					modalInfoParent.find(".modal-detail").removeClass("col-12").addClass("col-6");
					modalInfoParent.find(".modal-extra").show();
					
				}else{
					_modal.find(".modal-dialog").removeClass("modal-lg");
					modalInfoParent.find(".modal-detail").removeClass("col-6").addClass("col-12");
					modalInfoParent.find(".modal-extra").hide();
					$("#productInfoModal").modal();
				}

				_modalExtra.show();
				$("#productInfoModal").modal();
			}, error: function(){
				alert("Error on retrieving Product Info.");
			}

		});

		
	});

	$.extend($.expr[":"], {
		"containsin": function(elem, i, match, array) {

			var specialchar = "[\\x20\\t\\r\\n\\f]";
			var reg = new RegExp("\\\\([\\da-f]{1,6}" + specialchar + "?|(" + specialchar + ")|.)", "ig");
            var ee = function(e, t, n) {
                var r = "0x" + t - 65536;
                return r !== r || n ? t : r < 0 ? String.fromCharCode(r + 65536) : String.fromCharCode(r >> 10 | 55296, 1023 & r | 56320)
            };

			var compareStr = (match[3] || "").replace(reg, ee).toLowerCase();

			return (elem.textContent || elem.innerText || "").replace(/\r?\n|\r/g, "").toLowerCase().indexOf(compareStr) > -1;
		}
	});

	$.fn.serializeObject = function() {
		var o = {};
		var a = this.serializeArray();

		$.each(a, function() {
			if (o[this.name]) {
				if (!o[this.name].push) {
					o[this.name] = [o[this.name]];
				}
				o[this.name].push(this.value || '');
			} else {
				o[this.name] = this.value || '';
			}
		});
		return o;
	};

	dataTableSet();
	dateTimePickerSet();
	dateTimePicker2Set();
	smoothSlide();
	reloadDeferImg();
	bootstrapselectpicker();
	btnFormClear();
	colorpickerSet();
});
$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

function addCommas(nStr) {
    nStr += '';
    var x = nStr.split('.');
    var x1 = x[0];
    var x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}

function bootstrapselectpicker(){
	var selOption = {
		noneSelectedText: 'No selection',
		noneResultsText: 'No results matched',
		liveSearch: true
	};

	var sel = $(".bootstrap-select");

	if(sel.length > 0){
		sel.selectpicker(selOption);
	}
}

function btnFormClear(){
	var btn = $(".btn-form-clear");

	if(btn.length > 0){
		btn.click(function(){
			$(this).closest("form").find("input:not([type='submit']):not([type='hidden']):visible, select:visible, textarea:visible").val("");
			
			if($(".bootstrap-select").length > 0){
				$(".bootstrap-select").selectpicker("refresh");
			}
		});

		
	}
};

function dataTableSet(){
	var dt_TableSelector = $("table.table-datatable");
	
	if(dt_TableSelector.length > 0){
		dt_TableSelector.DataTable(DT_option);
	}
}

function dateTimePickerSet(){
	var dtp_Selector = $(".input-datetimepicker");

	if(dtp_Selector.length > 0){
		dtp_Selector.each(function(){
			var _this = $(this), _v = _this.val() || "";
			_this.datetimepicker(dtp_option);
			if(_v != ""){
				_this.data("DateTimePicker").date(_v);
			}
		});
	}
}



function dateTimePicker2Set(){
	var dtp_Selector = $(".input-datetimepicker2");

	if(dtp_Selector.length > 0){
		dtp_Selector.each(function(){
			var _this = $(this), _v = _this.val() || "";
			_this.datetimepicker(dtp_option2);
			if(_v != ""){
				_this.data("DateTimePicker").date(_v);
			}
		});
	}
}

function getUrlVars(){
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function reloadDeferImg(x){
	var selectedEle = x ? x : $(".img-defer");

	$(".img-defer").each(function(){
		var thisImg = $(this);
		var nodename = ($(this).prop("nodeName") || "").toLowerCase();

		var customsrc = $(this).attr("customsrc") || "";

		if(customsrc != ""){
			var tImg = new Image();
			tImg.src = customsrc;

			tImg.onload = function(){
				if(nodename == "img"){
					thisImg.attr("src", customsrc);
				}else{
					thisImg.css("backgroundImage", "url('" + customsrc + "')");
				}
			};

			tImg.onerror = function(){

			}
		}
	});
}

function shuffleString(x){
	(typeof x !== "string")&&(x = "");

	var a = x.split(""),
        n = a.length;

    for(var i = n - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var tmp = a[i];
        a[i] = a[j];
        a[j] = tmp;
    }
    return a.join("");
}

function getRandomHex(){
	var hexCode = shuffleString("0123456789ABCDEF");

	var color = '#';
	for (var i = 0; i < 6; i++) {
		color += hexCode[Math.floor(Math.random() * 16)];
	}
	return color;
}

function smoothSlide(x){
	x = x || 0; //I still figure what can be used.

	$("a.smooth-scroll").on("click", function(e){
		e.preventDefault();

		var mainNav = $("#mainNav");
		var mainNav_H = $("#mainNav").length ? $("#mainNav").outerHeight() || 0 : 0;

		var link = $(this).attr("href") || "";

		if(link != ""){
			var sel = $(link);

			if(sel.length > 0){
				var sel_offset_top = sel.offset().top;
				var scroll_to = sel_offset_top - mainNav_H;

				$("html, body").animate({ scrollTop: scroll_to }, scroll_to * 1.5);
			}
		}
	});
}

function num(x){
	return x.toString().replace(/[^0-9\.-]+/g,"");
}

function colorpickerSet(){
	var selectedEle = $(".input-colorpicker");

	if(selectedEle.length > 0){
		selectedEle.spectrum({
			showPalette: true,
			palette: palettes_default
		});
	}
}


function getDictionary() {
    return validateDictionary("ABCDEFGHIJKLMNOPQRSTUVWXYZ")

    function validateDictionary(dictionary) {
        for (let i = 0; i < dictionary.length; i++) {
            if(dictionary.indexOf(dictionary[i]) !== dictionary.lastIndexOf(dictionary[i])) {
                console.log('Error: The dictionary in use has at least one repeating symbol:', dictionary[i])
                return undefined
            }
        }
        return dictionary
    }
}

function numberToEncodedLetter(number) {
    //Takes any number and converts it into a base (dictionary length) letter combo. 0 corresponds to an empty string.
    //It converts any numerical entry into a positive integer.
    if (isNaN(number)) {return undefined}
    number = Math.abs(Math.floor(number))

    const dictionary = getDictionary()
    let index = number % dictionary.length
    let quotient = number / dictionary.length
    let result
    
    if (number <= dictionary.length) {return numToLetter(number)}  //Number is within single digit bounds of our encoding letter alphabet

    if (quotient >= 1) {
        //This number was bigger than our dictionary, recursively perform this function until we're done
        if (index === 0) {quotient--}   //Accounts for the edge case of the last letter in the dictionary string
        result = numberToEncodedLetter(quotient)
    }

    if (index === 0) {index = dictionary.length}   //Accounts for the edge case of the final letter; avoids getting an empty string
    
    return result + numToLetter(index)

    function numToLetter(number) {
        //Takes a letter between 0 and max letter length and returns the corresponding letter
        if (number > dictionary.length || number < 0) {return undefined}
        if (number === 0) {
            return ''
        } else {
            return dictionary.slice(number - 1, number)
        }
    }
}


function toNumeric(x){
	x = x || 0;
	if(x == ""){
		x = 0;
	}else{
		x = x.toString().replace(/[^0-9.]/g, '');
		if(isNaN(x) || x == ""){
			x = 0;
		}
	}
	return parseFloat(x);
}

function toNumber(x, allowE){
	x = x || 0;
	
	allowE = typeof allowE == "boolean" ? allowE : false;
	
	if(!allowE){
		if(x.toString().indexOf("e") >= 0){
			x == 0;
		}
	}
	
	return parseFloat(isNaN(x) ? 0 : x);
}

function toInt(x, base){
	x = toNumeric(x);
	
	var b = base ? toInt(base) : 10;
	
	var y = parseInt(x, b);
	
	return toNumeric(y);
}

function toFloat(x, y){
	x = toNumeric(x);
	y = toInt(y);
	
	if(y > 0){
		x = parseFloat(x.toFixed(y));
	}
	return x;
}

function numberWithCommas(x) {
	return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function getUrlVars(url)
{
    var vars = [], hash;
    var hashes =url.slice(url.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

function redirectTo(url){
	window.location.href = url;
}

function dateToInt(x){
	if(Object.prototype.toString.call(x) === "[object Date]" && x != "Invalid Date"){
		return x.getFullYear()*10000 + (x.getMonth() + 1) * 100 + x.getDate();
	}else{
		return -1;
	}
}

function dateToStr(x){
	if(Object.prototype.toString.call(x) === "[object Date]" && x != "Invalid Date"){
		var xMonth = x.getMonth() + 1, xDate = x.getDate();
		
		return x.getFullYear() + "-" + ("0" + xMonth).slice(-2) + "-" + ("0" + xDate).slice(-2);
	}else{
		return "";
	}
}

function setDatePickerToday(field){
if($("#"+field).val() == ""){
	$("#"+field).datepicker('setDate', new Date());
}
}

function addCommas(nStr, tSep, dSep) {
	tSep = tSep || ",";
	dSep = dSep || ".";
	
    nStr += '';
    x = nStr.split(dSep);
    x1 = x[0];
    x2 = x.length > 1 ? dSep + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
 
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + tSep + '$2');
    }
    return x1 + x2;
}

function toFixed( num, precision ) {
    return (+(Math.round(+(num + 'e' + precision)) + 'e' + -precision)).toFixed(precision);
}

function decimalPlace(num){
	var dp = (parseFloat(num).toString().split(".")[1] || "").length; 
	return dp;
}

function plus(a, b){
	a = toNumber(a), b = toNumber(b);
	
	var maxDP = Math.min(15, Math.max(decimalPlace(a), decimalPlace(b)));
	var multipler = Math.pow(10, maxDP);
	
	var mA = parseInt(a * multipler, 10), mB = parseInt(b * multipler, 10);
	
	return (mA + mB) / multipler;
}

function minus(a, b){
	a = toNumber(a), b = toNumber(b);
	
	var maxDP = Math.min(15, Math.max(decimalPlace(a), decimalPlace(b)));
	var multipler = Math.pow(10, maxDP);
	
	var mA = parseInt(a * multipler, 10), mB = parseInt(b * multipler, 10);
	
	return (mA - mB) / multipler;
}

function discountedValue(num, percentage, decimalplace){
	num = toNumber(num), percentage = toNumber(percentage);
	
	var discountAmount = num * percentage / 100;
	
	return decimalplace && decimalplace > 0 ? parseFloat(toFixed(discountAmount, decimalplace)) : discountAmount;
}

function discountedPercentage(num, discount, decimalplace){
	num = toNumber(num), discount = toNumber(discount);
	
	var discountPercentage = num == 0 ? 0 : (discount * 100 / num);
	
	return decimalplace && decimalplace > 0 ? parseFloat(toFixed(discountPercentage, decimalplace)) : discountPercentage;
}
