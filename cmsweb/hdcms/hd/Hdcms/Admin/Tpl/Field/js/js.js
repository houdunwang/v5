//表单验证
$(function () {
    $("form").validate({
        //验证规则
        title: {
            rule: {
                required: true,
                china: true
            },
            error: {
                required: "字段标题不能为空",
                china: "不能输入特殊字母"
            }
        },
        field_name: {
            rule: {
                required: true,
                regexp: /^[a-z]\w*$/i,
                ajax: {url: CONTROL + "&m=field_is_exists", field: ["mid"]}
            },
            error: {
                required: "字段名不能为空",
                regexp: "必须输入英文字母",
                ajax: "字段已经存在"
            }
        }
    })
})

//===========================添加&修改模型==========================
//选择字段模板
$(function () {
    //模板类型缓存
    var field_tpl = {};
    $("#field_type").change(function () {
        var field_type = $(this).val();
        if (field_tpl[field_type]) {
            $(".field_tpl").html(field_tpl[field_type]);
        } else {
            $.ajax({
                url: CONTROL + "&m=get_field_tpl",
                type: "POST",
                data: {field_type: field_type, tpl_type: tpl_type, mid: mid},
                cache: false,
                success: function (data) {
                    field_tpl[field_type] = data;
                    $(".field_tpl").html(data);
                }
            })
        }
    })
    //加载时触发，add时默认加载input模板
    $("#field_type").trigger("change");
})

//==================================验证规则切换
$(function () {
    $("#field_check").live("change", function () {
        $("[name='validate']").val($(this).val());
    })
})

//===========================更新字段缓存
function update_cache(mid) {
    $.ajax({
        type: "POST",
        url: CONTROL + "&m=update_cache",
        data: {mid: mid},
        dataType: "JSON",
        success: function (stat) {
            if (stat == 1) {
                $.dialog({
                    message: "缓存更新成功",
                    type: "success",
                    timeout: 3,
                    close_handler: function () {
                        location.href = URL;
                    }
                });
            } else {
                $.dialog({
                    message: "缓存更新失败",
                    type: "error",
                    timeout: 3
                });
            }
        }
    })
}

//=================================删除字段
function del_field(mid, fid) {
    $.ajax({
        type: "POST",
        url: CONTROL + "&m=del_field",
        data: {fid: fid, mid: mid},
        dataType: "JSON",
        success: function (stat) {
            if (stat == 1) {
                $.dialog({
                    message: "删除成功",
                    type: "success",
                    close_handler: function () {
                        location.href = URL;
                    }
                });
            }else {
                $.dialog({
                    message: "删除失败",
                    type: "error",
                });
            }
        }
    })
}
//===========================排序
function update_sort(mid) {
    $.ajax({
        type: "POST",
        url: CONTROL + "&m=updateSort&mid="+mid,
        data: $('input').serialize(),
        dataType: "JSON",
        success: function (data) {
            if (data.state== 1) {
                $.dialog({
                    message: data.message,
                    type: "success",
                    close_handler: function () {
                        location.href = URL;
                    }
                });
            } else {
                $.dialog({
                    message: data.message,
                    type: "error",
                });
            }
        }
    })
}











































