//----------获得站内图片与未使用图片-----------------
//点击分页时获取数据
$(function () {
    $('div.page1 a').live('click', function () {
        var _url = $(this).attr('href');
        var _div = $(this).parents('.pic_list').eq(0);
        $.get(_url, function (data) {
            _div.html(data);
        })
        return false;
    })
})
//----------获得站内图片与未使用图片-----------------


//选中图片操作
$("img").live("click", function () {
    if ($(this).attr("selected") == "selected") {
        //反选（原来选中的图片取沙选中)
        $(this).parents('li').eq(0).css({"border": "2px solid #dcdcdc"}).find("img").removeAttr("selected");
    } else if ($("img[selected='selected']").length >= num) {
        //判断选中数量
        alert("只能选择" + num + "个文件。请取消已经选择的文件后再选择");
    } else {
        //成功选中
        $(this).parent().css({"border": "2px solid #E93614"}).find("img").attr("selected", "selected");
    }
})
/**
 * 文本框失去焦点时改变upload表中的name值 (上传文件描述）
 * 就是改变图片的alt值
 */

$(function () {
    $("input").live('blur', function () {
        var obj = $(this);
        var id = $(this).parents('li').eq(0).find('input[name=table_id]').val();
        var name = $(this).val();
        //异步修改表单值
        $.post(CONTROL + '&m=update_file_name', {id: id, name: name}, function () {
        });
    })
})

//点击确定
$(function () {
    $("#pic_selected").click(function () {
        switch (type) {
            case "thumb":
                //父级IMG标签
                var _p_obj = $(parent.document).find("#" + id);
                //父级input表单
                var _input_obj = $(parent.document).find("[name=" + id + "]");
                //选中的图片
                var _img = $("img[selected='selected']").eq(0);
                //更改父级img标签src值
                _p_obj.attr("src", _img.attr("src"));
                //更改父级input值
                _input_obj.val(_img.attr("path"));
                break;
            //单图
            case "image":
                var _input_obj = $(parent.document).find("#" + id);
                var _img = $("img[selected='selected']").eq(0);
                _input_obj.val(_img.attr("path"));
                _input_obj.attr("src", _img.attr("src"));
                break;
            case "images":
                var img_div = $(parent.document).find("#" + id);
                //所有选中的图片
                var _img = $("img[selected='selected']");
                var _ul = "<ul>";
                $(_img).each(function (i) {
                    var _alt = $(this).parent().find("[name*=alt]").val();
                    _ul += "<li>";
                    _ul += "<div class='img'><img src='" + ROOT + "/" + $(_img[i]).attr("path") + "'/>";
                    _ul += "<a href='javascript:;' onclick='remove_upload(this,\"" + id + "\")'>X</a>";
                    _ul += "</div>";
                    _ul += "<input type='hidden' name='" + name + "[path][]'  value='" + $(_img[i]).attr("path") + "' src='" + $(_img[i]).attr("src") + "' class='w400 images'/> ";
                    _ul += "<input type='text' name='" + name + "[alt][]' style='width:135px;' value='" + _alt + "'/>";
                    _ul += "</li>";
                })
                _ul = _ul + "</ul>";
                img_div.append(_ul);
                //父窗口中记录数量的span标签
                var _num_span = $(parent.document).find('#hd_up_' + id);
                //更改数量
                _num_span.text(_num_span.text() * 1 - _img.length);
                break;
            case "files":
                var img_div = $(parent.document).find("#" + id);
                //所有选中的图片
                var _img = $("img[selected='selected']");
                var _ul = "<ul>";
                $(_img).each(function (i) {
                    var _alt = $(this).parent().find("[name*=alt]").val();
                    _ul += "<li style='width:45%'>";
                    _ul += "<img src='" + HDPHPEXTEND + "/Org/Uploadify/default.png' style='width:50px;height:50px;'/>";
                    _ul += "<input type='hidden' name='" + name + "[path][]'  value='" + $(_img[i]).attr("path") + "'/> ";
                    _ul += "描述：<input type='text' name='" + name + "[alt][]' style='width:200px;' value='" + _alt + "'/>";
                    _ul += "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    _ul += "下载金币：<input type='text' name='" + name + "[credits][]' style='width:200px;' value='0'/>";
                    _ul += "&nbsp;&nbsp;&nbsp;<a href='javascript:;' onclick='remove_upload(this)'>删除</a>";
                    _ul += "</li>";
                })
                _ul = _ul + "</ul>";
                img_div.append(_ul);
                //父窗口中记录数量的span标签
                var _num_span = $(parent.document).find('#hd_up_' + id);
                //更改数量
                _num_span.text(_num_span.text() * 1 - _img.length);
                break;
        }
        close_window();
    })
})
//uploadify上传完图片后自动选中
function hd_upload(file, data, response){
	$("#upload img:last").trigger('click');
}
//关闭
function close_window() {
    $(parent.document).find("[class*=modal]").remove();
}




































