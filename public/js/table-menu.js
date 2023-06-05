
var _target = null;

Object.filter = (obj, predicate) => 
    Object.keys(obj)
          .filter( key => predicate(obj[key]) )
          .reduce( (res, key) => (res[key] = obj[key], res), {} );

var _currentSelection = {};
$(function(){

	$("#year, #month, #week").on("change", function(){
		var _t = $(this);
		var _y = $("#year").val() || "", _m = $("#month").val() || "", _w = $("#week").val() || "";
		var _momn = moment([_y, _m - 1, 1, 0, 0, 0]);
		_momn.startOf("isoweek");

		if(_t.is("#year") || _t.is("#month")){
			$("#week").html("");
			
			for(var m = 1; m < 7; m++){
				$("#week").append("<option value='" + m + "'>" + m + "</option>");
				_momn.add(7, "d");

				if(_momn.month() != (_m - 1)){
					break;
				}
			}

			$("#week").val(_w <= m ? _w : m);
		}

		generateMenus();
	});

	$("#menu-container").on("click", ".btn-add, .btn-edit", function(){
		var _t = $(this);
		var _td = _t.closest("td");
		_target = _td;

		var _selectedCode = [];

		if(_t.hasClass("btn-edit")){

			_td.find("div.product-container").each(function(){
				var _container = $(this);
				var _pt = _container.data("_c") == "Y" ? "g" : "p";
				var _pi = _container.data("_pid");

				_selectedCode.push(_pt + _pi);
			});

		}

		var _type = _td.data("_t") || "";

		var _data = $("#menu-container").data("p") || null;
		$("#modal-product-lists").data({
			"_t": _type, 
			"_d": _td.data("_d") || "",
			"_m": _td.data("_m") || "",
			"_y" : _td.data("_y") || "",
			"_mo" : _td.data("_mo") || "",
			"_day" : _td.data("_day") || "",
			"_w" :  _td.data("_w") || "",
		});

		$("#modal-product-lists").html("");
		$("#modal-product-btnSubmit").text(_t.hasClass("btn-edit") ? "Save" : "Add");

		var _categories = $("#menu-container").data("_c") || [];
		var _categoriesCount = Object.keys(_categories).length;

		if(_data != null && _categoriesCount > 0){
			var _ul = $("<ul>").addClass("nav nav-tabs nav-justified");
			var _tCount = 0;

			var _div = $("<div>").addClass("tab-content");

			for(var c in _categories){
				var _cTrim = $.trim(c).replace(/ /g, "");

				var _cc = _categories[c] || "";

				var _li = $("<li>").addClass("nav-item").append(
					$("<a>").addClass("nav-link" + (_tCount == 0 ? " active" : "")).attr({
						"id" : _cTrim + "-product-tab",
						"href" : "#" + _cTrim + "-product-tabpane",
						"data-toggle" : "tab",
						"role" : "tab"
					}).append(
						$("<span>").addClass("align-middle").text(_cc)
					)
				);
		
				_ul.append(_li);

				var _divPane = $("<div>").addClass("tab-pane" + (_tCount == 0 ? " active" : "")).attr({
					"id" : _cTrim + "-product-tabpane",
					"role" : "tabpanel"
				});
				
				var _match = Object.filter(_data, function(n){
					return n["cat"] == c && (n["t"] == _type || (n["t"].indexOf(_type) !== -1));
				});
				console.log(c, _match, _type);

				for(var _d in _match){
					var _da = _data[_d];
					var _dapt = _da["pt"], _dapi = _da["id"];

					_divPane.append(
						$("<div>").addClass("d-inline-flex flex-row flex-wrap").append(
							$("<div>").addClass("div-products" + ( _selectedCode.indexOf(_dapt + _dapi) > -1 ? " selected" : "")).data({"_pt" : _da["pt"], "_pi" : _da["id"]}).append(
								$("<div>").addClass("font-weight-bold div-products-name").text(_da["pn"])
							)
							.append($("<div>").addClass("div-products-alter").text(_da["pa"]))
							.append($("<div>").addClass("div-products-description").text(_da["pd"]))
						)
					);
				}
				_div.append(_divPane);

				_tCount++;
			}
			$("#modal-product-lists").append(_ul).append(_div);
		}

		$("#productModal").modal({
			"backdrop" : "static"
		});
	}).on("click", ".btn-delete", function(){
		if(confirm("Remove Products?")){
			showOverlay();

			var _t = $(this);
			var _container = _t.closest("div.product-container");
			var _td = _container.closest("td");

			_id = _container.data("_i");

			$.ajax({
				url: ajaxUrl + "/" + _id,
				type: "delete",
				dataType: "json",
				success: function(_data){
					if(_data.status == "ok"){
						_container.remove();

						if(_td.find("div.product-container").length == 0){
							_td.append(
								$("<div>").addClass("btn-container").append(
									$("<button>").addClass("btn btn-icon rounded-circle btn-success btn-add")
										.append($("<i>").addClass("bx bx-plus"))
								)
							);
						}
						hideOverlay();
					}else{
						alert("Fail to remove item. Message: " + (_data.message || ""));
						hideOverlay();
					}
				}, error: function(){
					alert("Error on removing Items.");
					hideOverlay();
				}
			});
		}
	});
	
	$("#modal-product-lists").on("click", ".div-products", function(){
		var _this = $(this);
		if(_this.hasClass("selected")){
			_this.removeClass("selected")
		}else{
			_this.addClass("selected")
		}
	});

	$("#modal-product-btnSubmit").on("click", function(){
		var _selected = $(".div-products.selected");
		var _selectedLength = _selected.length;
		if(_selectedLength > 0){
			showOverlay();
			var _i = $("#modal-product-lists").data();
			var _id = _i._i || 0;

			var _selectedArr = [];
			_selected.each(function(){
				_selectedArr.push($(this).data());
			});

			var _data = Object.assign({
				"_date" : _target.data("_date"), 
				"_type" : _target.closest("table").data("_t"), 
				"_selected" : _selectedArr
				},
				_i);

			$.ajax({
				url: ajaxUrl,
				type: "post",
				data: _data,
				dataType: "json",
				success: function(_data){
					if(_data.status == "ok"){
						var _d = _data.data || [];
						var _dlength = _d.length;

						_target.html("");

						for(var d = 0; d < _dlength; d++){
							_target.append(productBlock(_d[d]));
						}
						_target = null;

						$("#productModal").modal("hide");
						hideOverlay();
					}else{
						alert("Fail to assign item. Message: " + (_data.message || ""));
						hideOverlay();
					}
				}, error: function(){
					alert("Error on assigning Items.");
					hideOverlay();
				}
			});
		}
	});
});

function getProducts(gMenu){
	showOverlay();

	$.ajax({
		url: ajaxUrl + "/allproducts",
        type: "post",
		dataType: "json",
		success: function(_data){
			$("#menu-container").data("p", _data);
			hideOverlay();
			if(gMenu){
				generateMenus();
			}
		},error: function(){
			alert("Error on Getting Data");
			hideOverlay();
		}
	});
}

function generateMenus(){
	var _y = $("#year").val() || "", _m = $("#month").val() || "", _w = $("#week").val() || "";

	showOverlay();

	_currentSelection = {
		"year" : _y,
		"month" : _m,
		"week" : _w,
	};

	$.ajax({
		url: ajaxUrl + "/get",
        type: "post",
		data: _currentSelection,
		dataType: "json",
		success: function(_data){
			generateTables(_data);
			hideOverlay();
		},error: function(){
			alert("Error on Getting Data");
			hideOverlay();
		}
	});
}

function generateTables(_data){
	var _y = $("#year").val() || "", _mo = $("#month").val() || 1, _we = $("#week").val() || "";

	var _t = _data["t"] || {}, _m = _data["m"] || {}, _w = _data["w"] || {}, _c = _data["c"] || {}, _p = _data["p"] || {};

	$("#menu-container").html("").data({
		"_t" : _t,
		"_m" : _m,
		"_w" : _w,
		"_c" : _c
	}).append(
		$("<button>").attr({
			"type" : "button",
			"id" : "btn-copy"
		}).addClass("btn btn-primary mr-1 mb-1").text("Copy Menu")
	);

	var _ul = $("<ul>").addClass("nav nav-tabs nav-justified");

	var _tCount = 0;
	for(var t in _t){
		var _tTrim = $.trim(t).replace(/ /g, "");

		var _tc = _t[t] || "";

		var _li = $("<li>").addClass("nav-item").append(
			$("<a>").addClass("nav-link" + (_tCount == 0 ? " active" : "")).attr({
				"id" : _tTrim + "-tab",
				"href" : "#" + _tTrim + "-tabpane",
				"data-toggle" : "tab",
				"role" : "tab"
			}).append(
				$("<span>").addClass("align-middle").text(_tc)
			)
		);

		_ul.append(_li);
		_tCount++;
	}
	$("#menu-container").append(_ul)

	var _divTab = $("<div>").addClass("tab-content");

	_tCount = 0;
	for(var t in _t){
		var _tTrim = $.trim(t).replace(/ /g, "");

		var _moment = moment([_y, _mo - 1, 1, 0, 0, 0]);
		_moment.add((_we - 1) * 7, "d");
		_moment.startOf("isoweek");

		var _divPane = $("<div>").addClass("tab-pane" + (_tCount == 0 ? " active" : "")).attr({
			"id" : _tTrim + "-tabpane",
			"role": "tabpanel"
		});
		_tCount++;
		var _div = $("<div>").attr({"id" : "div_" + t}).addClass("table-responsive");
		var _tc = _t[t] || "";
		_div.append($("<div>").addClass("d-flex justify-content-between")
			.append($("<div>").append($("<h5>").text(_tc)))
			.append($("<div>").append(""))
		);

		var _table = $("<table>").data({"_t" : t}).addClass("table table-bordered table-menu");
		var _theadtr = $("<tr>").append($("<td>").css({"width": "10px"}));
		for(var m in _m){
			_theadtr.append($("<td>").text(_m[m]));
		}
		_table.append($("<thead>").append(_theadtr));
		
		var _tbody = $("<tbody>");

		for(var w in _w){
			var _tbodytr = $("<tr>").append($("<td>").text(w).append("<br/>" + _moment.format("DD/MM/YYYY")));

			for(var m in _m){
				var _producttd = $("<td>").addClass("td-product").data({
					"_y" : _y,
					"_mo" : _mo,
					"_day" : _moment.date(),
					"_date" : _moment.format("YYYY-MM-DD"),
					"_w" : _we,
					"_t" : t,
					"_d" : _w[w],
					"_m" : m
				});

				var indicator = _w[w] + "_" + _moment.format("YYYY-MM-DD");

				var _productCount = 0;

				if(_p[t] && _p[t][indicator]){

					var _product = _p[t][indicator][m] || [];
					_productCount = _product.length;

					for(var i = 0; i < _productCount; i++){
						_producttd.append(productBlock(_product[i]));
					}
				}
				
				if(_productCount == 0){
					_producttd.append(
						$("<div>").addClass("btn-container").append(
							$("<button>").addClass("btn btn-icon rounded-circle btn-success btn-add")
								.append($("<i>").addClass("bx bx-plus"))
						)
					)
				}
				_tbodytr.append(_producttd);
			}
			_tbody.append(_tbodytr);
			_moment.add(1, "d");
		}
		_table.append(_tbody);
		_div.append(_table);
		_divTab.append(_divPane.append(_div));
	}
	$("#menu-container").append(_divTab);
}

function productBlock(_data){
	var _pdata = $("#menu-container").data("p");

	var _c = _data["_c"] || "N", _i = _data["_i"] || 0, _pid = _data["_p"] || 0;

	var _proddata = _pdata[(_c == "Y" ? "g" : "p") + _pid] || null;
	
	var _d = $("<div>").addClass("border-light product-container").data({"_i" : _i, "_c" : _c, "_pid" : _pid}).append(
		$("<div>").addClass("product-info").append(
			$("<div>").addClass("product-name").text(_proddata == null ? "**Missing Product Info**" : _proddata["pn"])
		).append(
			$("<div>").addClass("product-description").text(_proddata == null ? "**Missing Product Info**" : _proddata["pd"])
		).append(
			$("<div>").addClass("product-alternate").text(_proddata == null ? "**Missing Product Info**" : _proddata["pa"])
		).append(
			$("<div>").addClass("product-remarks").text(_data["_r"] || "")
		)
	).append(
		$("<div>").addClass("btn-container").append(
			$("<button>").addClass("btn btn-primary rounded-0 btn-edit")
				.append($("<i>").addClass("bx bx-edit"))
		).append(
			$("<div>").addClass("w-100")
		).append(
			$("<button>").addClass("btn btn-danger rounded-0 btn-delete")
				.append($("<i>").addClass("bx bx-x"))
		)
	);

	return _d;
}