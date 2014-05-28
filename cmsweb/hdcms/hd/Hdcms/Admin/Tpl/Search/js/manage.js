//全选 or  反选
$(function () {
    //全选
    $("input#select_all").click(function () {
        $("[type='checkbox']").attr("checked", $(this).attr("checked") == "checked");
    })
    //底部按钮
    $("input.s_all").click(function () {
        $("[type='checkbox']").attr("checked", "checked");
    })
    //反选
    $("input.r_select").click(function () {
        $("[type='checkbox']").attr("checked", function () {
            return !$(this).attr("checked") == 1
        });
    })
})
//删除
function del(sid) {
    if (sid) {
        var data = {'sid[]': sid};
    } else {
        var data = $("[name*='sid']:checked").serialize();
    }
    if (!data) {
        alert("请选择删除的关键词");
        return;
    }
    if (confirm("确定要删除搜索词吗?")) {
        $.ajax({
            type: "POST",
            url: CONTROL + "&m=del",
            cache: false,
            data: data,
            dataType:'json',
            success: function (data) {
                if (data.state == 1) {
                    $.dialog({
                        message: data.message,
                        type: "success",
                        close_handler: function () {
                            window.location.reload();
                        }
                    });
                } else {
                    $.dialog({
                        message: "删除失败",
                        type: "error"
                    });
                }
            }
        })
    }
}