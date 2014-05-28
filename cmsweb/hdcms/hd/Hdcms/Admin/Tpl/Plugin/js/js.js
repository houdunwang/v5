//删除与添加插件
$(function() {
	$('form').submit(function() {
		$.post(METH, $(this).serialize(), function(data) {
			if (data.state == 1) {
				$.dialog({
					"message" : data.message,
					"type" : "success",
					"close_handler" : function() {
						//更新后台菜单
						top.location.reload(true);
					}
				});
			} else {
				$.dialog({
					"message" : data.message,
					"type" : "error",
					"close_handler" : function() {
						//更新后台菜单
						top.location.reload(true);
					}
				});
			}
		}, 'JSON')
		return false;
	})
})