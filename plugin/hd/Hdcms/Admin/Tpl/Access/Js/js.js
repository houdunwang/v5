//复选框选后，将子集checked选中
$(function () {
    $("input").click(function () {
        var _obj = $(this);
        //将所有子节点选中
        $(this).parents("li").eq(0).find("input").not($(this)).each(function (i) {
            $(this).attr("checked", _obj.attr("checked") == "checked");
        });
        //将父级NID选中
        if ($(this).attr("checked")) {
            $(this).parents("li").each(function (i) {
                $(this).children("label,h3,h4").find("input").attr("checked", "checked");
            })
        }
    })
})