//全选 or  反选
$(function () {
    //全选
    $("input#select_all").click(function () {
        $("[type='checkbox']").attr("checked", $(this).attr("checked") == "checked");
    })
})

//删除
function del(tid) {
    if (tid) {
        var data = {'tid[]': tid};
    } else {
        var data = $("[name*='tid']:checked").serialize();
    }
    if (!data) {
        alert("请选择删除的tag");
        return;
    }
    if (confirm("确定要删除tag吗?")) {
        hd_ajax(CONTROL + '&m=del', data);
    }
}