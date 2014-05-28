//选择模板
function getTplFile(path) {
	//当前文件地址
	$(parent.document).find('#'+fieldName).val(path);
	//关闭父级modal对话框
	parent.close_select_template();
}
//获得模板列表
function getFileList(url) {
	$.post(url, function(html) {
		$("#select_tpl").html(html);
	})
}
