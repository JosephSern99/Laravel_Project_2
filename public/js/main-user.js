$(function(){
	
});

function cartlisttemplate(id, obj, _result){
	var name = obj["name"] || "";
	
	var _oldPrice = parseFloat(parseFloat(obj["price"] || 0).toFixed(2));
	var price = addCommas(_oldPrice.toFixed(2));
	
	var _newPrice = parseFloat(parseFloat(_result && _result["pricing"] && _result["pricing"][0] && _result["pricing"][0]["price"] || 0).toFixed(2));
	
	var _resultPrice = addCommas(_newPrice.toFixed(2));
	var _resultQty = parseFloat(_result && _result["pricing"] && _result["pricing"][0] && _result["pricing"][0]["qty"] || 0)
	var _foc = _result && _result["foc"] && _result["foc"][0] && _result["foc"][0]["foc"];

	var remark = obj["productremark"] || "";
	var qty = obj["qty"] || 0;
	var supplierid = obj["supplierid"] || "";
	var suppliername = obj["suppliername"] || "";
	var uom = obj["uom"] || "";
	var essential = obj["essential"] || "";

	var totalprice = addCommas((parseFloat(num(qty)) * parseFloat(num(_newPrice > 0 ? _newPrice : _oldPrice))).toFixed(2))
	
	var _div = $("<div>").addClass("product-info").attr({
		"prdcd" : id,
		"vid" : supplierid,
		"productid" : id.split("_")[0] || 0
	}).append(
		$("<div>").addClass("product-checkbox").append(
			$("<input>").addClass("checkbox-product").attr({
				"type" : "checkbox"
			}).prop("checked", true)
		)
	).append(
		$("<div>").addClass("product-info-block").append(
			$("<div>").addClass("div-image").append(
				$("<img>").attr({
					"src" : _result["img"] || "",
					"alt" : "Product Image"
				}).addClass("product-image")
			)
		).append(
			$("<div>").addClass("div-product").append(
				$("<div>").addClass("product-description").append($("<a>").addClass("product-link cursor-pointer").text(name)).append(
					$("<input>").attr("type", "hidden").addClass("input-essential").val(essential ? "Y" : "N")
				)
			).append(
				$("<div>").addClass("product-vendor").text(suppliername)
			).append(
				$("<div>").addClass("product-remarks").text(remark)
			).append(
				$("<div>").addClass("product-remarks").text(remark)
			).append(
				$("<div>").addClass("product-price").append(
					$("<span>").addClass("price-sign").text("$ ")
				).append(function(){
					var _spanContainer = $("<span>").addClass("span-price-container");

					var _span = $("<span>").addClass("span-price");
					
					if(_newPrice > 0){
						_span.text(_resultPrice);
					}else{
						_span.text(price)
					}
					_spanContainer.append(_span);

					_spanContainer.append($("<span>").addClass("old-price ml-1" + ((_newPrice <= 0 || _resultQty <= 1) ? " d-none" : "")).append($("<s>").text(function(){
						if(_newPrice > 0 && _newPrice != _oldPrice){
							return price;
						}
						return "";
					})));

					return _spanContainer;
					}
				).append(
					$("<span>").addClass("product-uom").text(uom)
				)
			).append(
				$("<div>").addClass("div-discount-percentage row").css("white-space", "nowrap").append(
					$("<div>").addClass("text-left col-6").text("Discount (%): ")
				).append(
					$("<div>").addClass("col-6 font-weight-bold").append(
						$("<input>").attr({
							"type" : "number",
							"step" : "any"
						}).addClass("text-right form-control form-control-sm input-discount").val(0)
					)
				)
			).append(
				$("<div>").addClass("div-discount-amount row").css("white-space", "nowrap").append(
					$("<div>").addClass("text-left col-6").text("Discount: ")
				).append(
					$("<div>").addClass("text-right col-6 font-weight-bold").append(
						$("<span>").addClass("text-right span-discount").text(0)
					)
				)
			).append(
				$("<div>").addClass("div-total").css("white-space", "nowrap").append(
					$("<div>").addClass("float-left mr-1").text("Total: ")
				).append(
					$("<div>").addClass("text-right font-weight-bold").text("$").append(
						$("<span>").addClass("price").text(totalprice)
					)
				).append(
					$("<div>").addClass("float-left mr-1").text("Item Remarks: ")
				).append(
					$("<div>").append(
						$("<textarea>").addClass("item-remarks form-control")
					)
				).append(function(){
					var _focDiv = $("<div>").addClass("div-foc font-weight-bold").append($("<span>").addClass("span-foc").html(function(){
						if(_foc > 0){
							return "Free: " + _foc;
						}
						return "";
					}));
					
					_focDiv.append($("<input>").attr("type", "hidden").addClass("hidden-foc").val(_foc));
						
					return _focDiv;
				})
			)
		).append(
			$("<div>").addClass("div-quantity").append(
				$("<div>").addClass("btn-increment").append(
					$("<i>").addClass("fa fa-sort-up")
				)
			).append(
				$("<div>").addClass("div-input").append(
					$("<input>").addClass("quantity").attr({
						"type": "text",
						"maxlength" : 4
					}).val(qty)
				)
			).append(
				$("<div>").addClass("btn-decrement").append(
					$("<i>").addClass("fa fa-sort-down")
				)
			)
		).append(
			$("<div>").addClass("div-remove").append(
				$("<span>").addClass("btn-remove").append(
					$("<i>").addClass("fa fa-times")
				)
			)
		)
	);


	return _div;
}

function vendortemplate(id, obj, link, territories){
	
	var name = obj["name"] || "";
	var moa = addCommas(parseFloat(obj["moa"] || 0).toFixed(2));
	var charge = addCommas(parseFloat(obj["charge"] || 0).toFixed(2));
	
	var _div = $("<div>").append(
		$("<div>").addClass("card-body p-2 div_vendor").attr({
			"vid" : id,
			"dc" : charge
		}).append(
			$("<div>").append(
				$("<div>").addClass("div_vendorinfo").append(
					$("<div>").addClass("vendorlbl").append(
						$("<a>").addClass("font-weight-bold").attr({
							"href" : link + "?id=" + id,
						}).text(name)
					)
				).append(
					$("<div>").addClass("btn-trash").append(
						$("<i>").addClass("fas fa-trash-alt")
					)
				)
			).append(
				$("<div>").addClass("div-moa").append(
					$("<i>").text("Minimum Order Amount: $ ").append(
						$("<span>").addClass("moa_amt").text(moa)
					)
				)
			).append(
				$("<div>").addClass("div_dcinfo free").append(
					$("<div>").addClass("dclbl").append(
						$("<i>").addClass("fas fa-handshake")
					)
				).append(
					$("<div>").addClass("dcamt").text("0.00")
				)
			).append(
				$("<div>").addClass("div_amtinfo").append(
					$("<div>").addClass("amtlbl").text("Amount: ")
				).append(
					$("<div>").addClass("amt").text("0.00")
				)
			)
		).append(
			$("<div>").addClass("div-territory-container").append(
				$("<label>").text("Branch: ")
			).append(
				$("<div>").addClass("div-territory").append(
					function(){
						var _s = $("<select>").addClass("select-territory form-control form-control-sm").append(
							$("<option>").attr("value", "").text("-- None --")
						);
						
						for(var _t = 0; _t < territories.length; _t++){
							_s.append(
								$("<option>").attr("value", territories[_t]["Capt_Code"] || 0).text(territories[_t]["Capt_US"] || "")
							)
						}
	
						return _s;
					}
				)
			)
		).append(
			$("<div>").addClass("div-deliverydate-container").append(
				$("<label>").text("Delivery Date: ")
			).append(
				$("<div>").addClass("div-deliverydate").append(
					$("<input>").addClass("input-deliverydate input-datetimepicker form-control form-control-sm").attr({
						"type": "text"
					})
				)
			)
		).append(
			$("<div>").addClass("div-deliveryplace-container").append(
				$("<label>").text("Delivery Location: ")
			).append(
				$("<div>").addClass("div-deliveryplace").append(
					$("<textarea>").addClass("textarea-deliveryplace form-control form-control-sm")
				)
			)
		).append(
			$("<div>").addClass("div-remark-container").append(
				$("<label>").text("Remarks: ")
			).append(
				$("<div>").addClass("div-remark").append(
					$("<textarea>").addClass("textarea-remark form-control form-control-sm")
				)
			)
		).append(
			$("<div>").addClass("div-justification-container").append(
				$("<label>").text("Justification: ")
			).append(
				$("<div>").addClass("div-justification").append(
					$("<textarea>").addClass("textarea-justification form-control form-control-sm")
				)
			)
		)
	).append(
		$("<hr>").addClass("m-0")
	);
	return _div;
}

function validateNumber(event) {
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode === 8 || event.keyCode === 46) {
        return true;
    } else if ( key < 48 || key > 57 ) {
        return false;
    } else {
    	return true;
    }
};