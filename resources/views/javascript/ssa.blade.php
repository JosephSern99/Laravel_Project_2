function setSSAEvent(opts){
    var ssaBeforeValue = null, ssaAfterValue = null, whereClause = {"Person": ""};
}

function checkIfString(v, caption){
    if(typeof v !== 'string'){
        throw new TypeError(caption + " expected to be String");
    }
}

$.fn.SetSSA = function(opts, values){
    if(typeof opts == 'object'){
		var connection = opts['connection'] || "",
			model = opts['model'] || '',
            column = opts['column'] || [],
            caption = opts['caption'] || '',
            value = opts['value'] || '',
            where = opts['where'] || '';

        if(!(column instanceof Array)){
            throw new TypeError('Options Column expected to be Array');
        }

		checkIfString(connection, 'Model');
        checkIfString(model, 'Model');
        checkIfString(caption, 'Caption');
        checkIfString(value, 'Value');
        checkIfString(where, 'Where');

        return this.each(function(){
            var _this = $(this), _options;
            if(!_this.data('SetSSA')){
                _this.find('.input-ssa').attr('autocomplete', 'off');
                var additionalOptions = {
                    setWhere: function(x){
                        var dt = _this.data('SetSSA');
                        if(x){
                            dt['where'] = x;
                        }
                    },
                    ssaBeforeValue: null,
                    ssaAfterValue: null,
                };

                _options = $.extend(true, {}, opts, additionalOptions);
                _this.data('SetSSA', _options);

                $("body").on("click", function(e){
                    if(e.target.id == "table_SSA" || $(e.target).closest("#table_SSA").length > 0){
                        return false;
                    }
                    if($("#table_SSA").length > 0){
                        $("#table_SSA").remove();
                    }
                });

                _this.on("click", ".search-ssa", function(e){
                    var _t = $(this), _input = _this.find('.input-ssa');

                    if(_input.hasClass("ssa-set")){
                        if(confirm("@lang("Clear Value?")")){
                            _input.removeClass("ssa-set").val("");
                            _this.find(".hidden-ssa").val("").trigger("change");
                            e.stopPropagation();
                        }
                    }else{
                        var ssaData = _this.data('SetSSA');
                        var ajaxData = {"ssa": "ssa"};
                        ajaxData["connection"] = ssaData['connection'];
                        ajaxData["model"] = ssaData['model'];
                        ajaxData["column"] = ssaData['column'];
                        ajaxData["caption"] = ssaData['caption'];
                        ajaxData["value"] = ssaData['value'];
                        ajaxData["filter"] = _input.val() || "";
                        ajaxData["whereClause"] = ssaData["where"];

                        $.ajax({
                            url: "{!! route($u) !!}",
                            method: "post",
                            data: ajaxData,
                            success: function(data){
                                _this.append(data);
                            }
                        });
                    }
                }).on("click", ".tableSSA_table_row", function(){
                    var _t = $(this), value = _t.find(".ssa_select_value").val(), caption = _t.find(".ssa_display_value").val();
                    var inputSSA = _this.find(".input-ssa");
                    if(!inputSSA.hasClass("ssa-set")){
                        inputSSA.addClass("ssa-set");
                    }
                    inputSSA.val(caption || "");
                    _this.find(".hidden-ssa").val(value || "").trigger("change");

                    $("#table_SSA").remove();
                }).on("keydown", ".input-ssa", function(e){
                    var keyCode = e.which || e.keyCode;
                    _this.data('SetSSA')['ssaBeforeValue'] = $(this).val();

                    if(keyCode == 13){
                        e.preventDefault();
                        _this.find(".search-ssa").trigger("click");

                        return false;
                    }

                }).on("keyup", ".input-ssa", function(e){
                    var _t = $(this);
                    var ssaAfterValue = _t.val();

                    if( _this.data('SetSSA')['ssaBeforeValue'] != ssaAfterValue){
                        _t.removeClass("ssa-set");
                        _this.find(".hidden-ssa").val("").trigger("change");
                    }
                });
            }
        });
    }else if(typeof opts == 'string'){
        var extraValue = values;

        this.each(function(){
            var _this = $(this), dt = _this.data('SetSSA');
            if(!dt){
                throw new Error('Call to a SetSSA ' + opts + ' function to a element that is not using SetSSA');
            }
            return dt[opts](extraValue);
        });
    }

    return this;
};
