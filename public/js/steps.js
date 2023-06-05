$(".step-link").on("click", function(){
    var _t = $(this), _target = _t.data("target");
    var _parent = $("[data-target='" + _target + "']").closest(".step");

    _parent.removeClass("done").addClass("current");
    _parent.prevAll().removeClass("current").addClass("done");
    _parent.nextAll().removeClass("done").removeClass("current");
    
    $("#tabsContent").find(".tab-pane.active").removeClass("active");

    $("#" + _target).tab('show');
});