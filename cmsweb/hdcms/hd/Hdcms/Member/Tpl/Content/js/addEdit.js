//添加或修改文章
$(function() {
	$("form").submit(function() {
		//验证内容
		if ($("#hd_content").length > 0 && !UE.getEditor('hd_content').hasContents()) {
			alert('内容不能为空');
			return false;
		}
		//表单验证
		if ($(this).is_validate()) {
			var _post = $(this).serialize();
			dialog_message("正在发表...", 30);
			$.ajax({
				type : "POST",
				url : METH,
				dataType : "JSON",
				cache : false,
				data : _post,
				success : function(data) {
					//关闭提示框
					dialog_message(false);
					if (data.state == 1) {
						$.modal({
							width : 250,
							height : 160,
							button : true,
							title : '消息',
							button_success : "继续操作",
							button_cancel : "关闭窗口",
							message : data.message,
							type : "success",
							success : function() {
								if (window.opener) {
									window.opener.location.reload();
								}
								window.location.reload();
							},
							cancel : function() {
								if (window.opener) {
									window.opener.location.reload();
								}
								window.close();
							}
						})
					} else {//错误
						$.dialog({
							message : data.message,
							type : "error"
						});
					}
				},
				error : function() {
					$.dialog({
						message : "请求超时，请稍候再试",
						type : "error"
					});
				}
			})
		}
		return false;
	})
})
//表单验证
//$(function() {
//	$("form").validate({
//		title : {
//			rule : {
//				required : true
//			},
//			error : {
//				required : "标题不能为空"
//			}
//		},
//		tag : {
//			rule : {
//				required : true
//			},
//			error : {
//				required : "标签不能为空"
//			},
//			message : '用逗号分隔'
//		},
//		read_credits : {
//			rule : {
//				required : true,
//				regexp : /^\d+$/
//			},
//			error : {
//				required : "阅读积分不能为空",
//				regexp : '必须为数字'
//			}
//		}
//	})
//})
