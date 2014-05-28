//点击input表单实现 全选或反选
$(function () {
    //全选
    $("input#select_all").click(function () {
        $("[type='checkbox']").attr("checked", $(this).attr("checked") == "checked");
    })
})
/**
 * 删除评论
 * @param mid
 * @param cid
 * @param aid
 */
function del(comment_id) {
    //单评论删除
    if (comment_id) {
        var comment_id = {comment_id: comment_id}
    } else {//多评论删除
        var comment_id = $("input:checked").serialize();
    }
    if (comment_id) {
        if (confirm("确定要删除评论吗?")) {
            $.ajax({
                type: "POST",
                url: CONTROL + "&m=del" ,
                dataType: "JSON",
                cache: false,
                data: comment_id,
                success: function (data) {
                    if (data.state == 1) {
                        $.dialog({
                            message: "删除评论成功",
                            type: "success",
                            timeout: 3,
                            close_handler: function () {
                                location.href = URL;
                            }
                        });
                    } else {
                        $.dialog({
                            message: "删除评论失败",
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
        alert("请选择删除的评论");
    }
}
/**
 * 设置状态
 * @param mid
 * @param cid
 * @param state
 */
function audit(state) {
    //单评论删除
    var comment_id = $("input:checked").serialize();

    if (comment_id) {
        $.ajax({
            type: "POST",
            url: CONTROL + "&m=audit" + "&state=" + state ,
            dataType: "JSON",
            cache: false,
            data: comment_id,
            success: function (data) {
                if (data.state == 1) {
                    $.dialog({
                        message: "设置成功",
                        type: "success",
                        timeout: 3,
                        close_handler: function () {
                            location.href = URL;
                        }
                    });
                } else {
                    $.dialog({
                        message: "设置失败",
                        type: "error",
                        close_handler: function () {
                            location.href = URL;
                        }
                    });
                }
            }
        })
    } else {
        alert("请选择设置的评论");
    }
}















