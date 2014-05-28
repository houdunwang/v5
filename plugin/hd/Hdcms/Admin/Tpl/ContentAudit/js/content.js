//点击input表单实现 全选或反选
$(function () {
    //全选
    $("input#select_all").click(function () {
        $("[type='checkbox']").attr("checked", $(this).attr("checked") == "checked");
    })
})
//全选文章
function select_all() {
    $("[type='checkbox']").attr("checked", "checked");
}
//反选文章
function reverse_select() {
    $("[type='checkbox']").attr("checked", function () {
        return !$(this).attr("checked") == 1;
    });
}
/**
 * 删除文章
 * @param mid
 * @param cid
 * @param aid
 */
function del() {
    var ids = $("input:checked").serialize();
    if (ids) {
        if (confirm("确定要删除文章吗?")) {
            $.ajax({
                type: "POST",
                url: CONTROL + "&m=del",
                dataType: "JSON",
                cache: false,
                data: ids,
                success: function (data) {
                    if (data.state == 1) {
                        $.dialog({
                            message: "删除文章成功",
                            type: "success",
                            timeout: 3,
                            close_handler: function () {
                                location.href = URL;
                            }
                        });
                    } else {
                        $.dialog({
                            message: "删除文章失败",
                            type: "error",
                            close_handler: function () {
                                location.href = URL;
                            }
                        });
                    }
                }
            })
        }
    } else {
        alert("请选择删除的文章");
    }
}
//设置状态
function audit(mid,state) {
    //单文章删除
    var ids = $("input:checked").serialize();
    if (ids) {
        $.ajax({
            type: "POST",
            url: CONTROL + "&m=audit" + "&state=" + state + "&mid="+mid,
            dataType: "JSON",
            cache: false,
            data: ids,
            success: function (data) {
                if (data.state == 1) {
                    $.dialog({
                        message: "设置文章成功",
                        type: "success",
                        timeout: 3,
                        close_handler: function () {
                            location.href = URL;
                        }
                    });
                } else {
                    $.dialog({
                        message: "设置文章失败",
                        type: "error",
                        close_handler: function () {
                            location.href = URL;
                        }
                    });
                }
            }
        })
    } else {
        alert("请选择设置的文章");
    }
}















