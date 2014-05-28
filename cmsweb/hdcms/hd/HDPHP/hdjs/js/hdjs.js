// ====================================================================================
// ===================================--|HDJS前端库|--======================================
// ====================================================================================
// .-----------------------------------------------------------------------------------
// |  Software: [HDJS framework]
// |   Version: 2013.08
// |      Site: http://www.hdphp.com
// |-----------------------------------------------------------------------------------
// |    Author: 后盾网向军 <houdunwangxj@gmail.com>
// | Copyright (c) 2012-2013, http://www.houdunwang.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
// |   License: http://www.apache.org/licenses/LICENSE-2.0
// '-----------------------------------------------------------------------------------
//去除超链接虚线
$(function() {
	$("a").focus(function() {
		$(this).trigger("blur")
	});
})
//新窗口打开链接
function hd_open_window(url, name) {
	name || '';
	window.open(url, name);
}

/**
 * 关闭窗口
 * @param msg 提示信息
 * @private
 */
function hd_close_window(msg) {
	//    msg = msg || '确定关闭吗？';
	if (msg && confirm(msg))
		window.close()
	else
		window.close();
}

/**
 * 获得对象在页面中心的位置
 * @author hdxj
 * @category functions
 * @param obj 对象
 * @returns {Array} 坐标
 */
function center_pos(obj) {
	var pos = [];
	//位置
	pos[0] = ($(window).width() - obj.width()) / 2
	pos[1] = $(window).scrollTop() + ($(window).height() - obj.height()) / 2
	return pos
}

// ====================================================================================
// =====================================--|UI|--=======================================
// ====================================================================================
// .-----------------------------------------------------------------------------------
// |  Software: [HDJS framework]
// |   Version: 2013.08
// |      Site: http://www.hdphp.com
// |-----------------------------------------------------------------------------------
// |    Author: 向军 <houdunwangxj@gmail.com>
// | Copyright (c) 2012-2013, http://www.houdunwang.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
// |   License: http://www.apache.org/licenses/LICENSE-2.0
// '-----------------------------------------------------------------------------------
/**
 * tab面板使用
 * @author hdxj
 * @category ui
 */
$(function() {
	//首页加载显示第一1个
	var index = $("div.tab ul.tab_menu li a").index($("a.action:gt(0)"));
	index = index > 0 ? index : 0;
	$("div.tab ul.tab_menu li a").removeClass("action");
	$("div.tab ul.tab_menu li:eq(" + index + ") a").addClass("action");
	$("div.tab div.tab_content").children("div").eq(index).addClass("action");
	$("div.tab_content").children("div").addClass("hd_tab_content_div");
	//点击切换
	$("div.tab ul.tab_menu li").click(function() {
		//改变标题 如果是链接，直接跳转
		if (/^http/i.test($(this).find("a").attr("href"))) {
			return true;
		}
		$("div.tab ul.tab_menu li a").removeClass("action");
		$("a", this).addClass("action");
		var _id = $(this).attr("lab");
		$("div.tab_content div").removeClass("action");
		$("div.tab_content div#" + _id).addClass("action");
	})
})
/**
 * dialog对话框
 */
$.extend({
	"close_dialog" : function() {
		$("div.dialog_bg").remove();
		$("div.dialog").remove();
	},
	"dialog" : function(options) {
		var _default = {
			"type" : "success"//类型 CSS样式
			,
			"message" : "message属性配置错误"//提示信息
			,
			"timeout" : 3//自动关闭时间
			,
			"close_handler" : function() {
			}//关闭时的回调函数
		};
		var opt = $.extend(_default, options);
		//创建元素
		if ($("div.dialog").length == 0) {
			//移除dialog_message对话框
			$('#hd_dialog_message').remove();
			$('#hd_dialog_message_bg').remove();
			var div = '';
			div += '<div class="dialog">';
			div += '<div class="close">';
			div += '<a href="#" title="关闭">×</a></div>';
			div += '<h2 id="dialog_title">提示信息</h2>';
			div += '<div class="con ' + opt.type + '"><strong>ico</strong>';
			div += '<span>' + opt.message + '</span>';
			div += '</div>';
			div += '</div>';
			div += '<div class="dialog_bg"></div>'
			$(div).appendTo("body");

		}
		var _w = $(document).width();
		var _h = $(document).height();
		$("div.dialog_bg").css({
			opacity : 0.8
		}).show();
		$("div.dialog").show();
		//定时id
		var dialog_id;
		//点击关闭dialog
		$("div.dialog div.close a").click(function() {
			opt.close_handler();
			$("div.dialog_bg").remove();
			$("div.dialog").remove();
			clearTimeout(dialog_id);
		})
		//自动关闭
		dialog_id = setTimeout(function() {
			//如果dialog已经关闭，不执行事件
			if ($("div.dialog").length == 0)
				return;
			opt.close_handler();
			$("div.dialog_bg").remove();
			$("div.dialog").remove();
		}, opt.timeout * 200);
	}
})
//简单提示框
function dialog_message(message, timeOut) {
	//删除提示框
	if (message === false) {
		$('#hd_dialog_message').remove();
		$('#hd_dialog_message_bg').remove();
	} else {
		var timeOut = timeOut ? timeOut * 1000 : 2000;
		//创建背景色
		var html = '<div id="hd_dialog_message_bg"></div>';
		html += "<div id='hd_dialog_message'>" + message + "</div>";
		$("body").append(html);
		//改变背景色
		$("div#hd_dialog_message_bg").css({
			opacity : 0.8
		});
		setTimeout(function() {
			$("div#hd_dialog_message").fadeOut("fast");
			$("div#hd_dialog_message_bg").remove();
		}, timeOut);
	}
}

/**
 * 模态对话框
 * @category ui
 */
$.extend({
	"modal" : function(options) {
		var _default = {
			title : '',
			content : '',
			height : 400,
			width : 600,
			button_success : '',
			button_cancel : '',
			message : false,
			type : "success",
			cancel : false, //事件
			success : false, //事件
			show : true//是否显示
		};
		var opt = $.extend(_default, options);
		//----------删除所有弹出框
		$("div.modal").remove();
		var div = '';
		var show = opt.show ? "" : ";display:none;"
		div += '<div class="hd-modal" style="position:fixed;left:50%;top:50px;margin-left:-' + (opt['width'] / 2) + 'px;width:' + opt['width'] + 'px;' + show + 'height:' + opt['height'] + 'px;z-index:1000">';
		//---------------标题设置
		if (opt['title']) {
			div += '<div class="hd-modal-title">' + opt['title'];
			//---------x关闭按钮
			div += '<button class="close" aria-hidden="true" data-dismiss="modal" type="button" onclick="$.removeModal()">×</button>';
			div += '</div>';
		}
		//--------------内容区域
		content_height = opt.height - 32;
		if (opt.button_success || opt.button_cancel) {
			content_height -= 46;
		}
		div += '<div class="content" style="height:' + content_height + 'px">';
		if (opt.message) {
			div += '<div class="hd-modal-message"><strong class="' + opt.type + '"></strong><span>' + opt.message + '</span></div>';
		} else {
			div += opt.content;
		}
		div += '</div>';
		//------------按钮处理
		if (opt.button_success || opt.button_cancel) {
			div += '<div class="hd-modal-footer" ' + (opt.message ? 'style="text-align:center"' : "") + '>';
			//确定按钮
			if (opt.button_success) {
				div += '<a href="javascript:;" class="btn btn-primary hd-success">' + opt.button_success + '</a>';
			}
			//放弃按钮
			if (opt.button_cancel) {
				div += '<a href="javascript:;" class="btn hd-cancel">' + opt.button_cancel + '</a>';
			}
			div += '</div>';
		}
		div += '</div>';
		div += '<div class="hd-modal-bg" style="' + show + '"></div>';
		$(div).appendTo("body");
		var pos = center_pos($(".modal"));
		//点击确定
		$("div.hd-modal-footer a.hd-success").click(function() {
			if (opt.success) {
				opt.success();
			} else {
				$("div.hd-modal-footer a.hd-cancel").trigger("click");
			}
			return true;
		})
		var _w = $(document).width();
		var _h = $(document).height();
		$("div.hd-modal-bg").css({
			opacity : 0.6
		});
		if (opt.show) {
			$("div.hd-modal-bg").show();
		}
		//点击关闭modal
		if (opt.cancel) {
			$("div.hd-modal-footer a.hd-cancel").live("click", opt.cancel);
		} else {
			$("div.hd-modal-footer a.hd-cancel").bind("click", function() {
				$.removeModal();
				return false;
			})
		}
	},
	"removeModal" : function() {
		$("div.hd-modal").fadeOut().remove();
		$("div.hd-modal-bg").remove();
	},
	modalShow : function(func) {
		$("div.hd-modal").show();
		$("div.hd-modal-bg").show();
		if ( typeof func == 'function')
			func();
	}
});
function hd_confirm(message, success, error) {
	return $.modal({
		width : 280,
		height : 160,
		title : "温馨提示",
		message : message,
		button_success : "确定",
		button_cancel : "关闭",
		type : 'notice', //类型
		success : function() {
			$.removeModal();
			//关闭模态
			success();
		}
	});

}

// ====================================================================================
// ===================================--|表单验证|--=====================================
// ====================================================================================
// .-----------------------------------------------------------------------------------
// |  Software: [HDJS framework]
// |   Version: 2013.08
// |      Site: http://www.hdphp.com
// |-----------------------------------------------------------------------------------
// |    Author: 后盾网向军 <houdunwangxj@gmail.com>
// | Copyright (c) 2012-2013, http://www.houdunwang.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
// |   License: http://www.apache.org/licenses/LICENSE-2.0
// '-----------------------------------------------------------------------------------

/**
 * 表单提交，没有确定按钮，倒计时关闭窗口
 * @param obj form表单对象
 * @param url 成功时的跳转url
 * @param timeout 超时时间
 * @returns {boolean}
 */
function hd_submit(obj, url, func,timeout) {
	if ($(obj).is_validate()) {
		//阻止多次表单提交，提交结束后在hd_submit方法中解锁
		if ($(obj).attr('disabled')) {
			return false;
		}
		$(obj).attr('disabled', 1);
		var post = $(obj).serialize();
		$.ajax({
			type : "POST",
			url : $(obj).attr("action"),
			cache : false,
			data : post,
			timeout : 10000,
			success : function(data) {
				$(obj).removeAttr('disabled');
				if ( typeof data == 'object' || data.substr(0, 1) == '{') {
					data = jQuery.parseJSON(data);
					if (data.state == 1) {
						$.dialog({
							message : data.message,
							timeout : timeout || 1,
							type : "success",
							close_handler : function() {
								if (url) {
									location.href = url
								}
								if (func) {
									func();
								}
							}
						});
					} else {
						//解锁
						$(obj).removeAttr('disabled');
						$.dialog({
							message : data.message || "操作失败",
							timeout : data.timeout || 3,
							type : "error"
						});

					}
				} else {
					//解锁
					$(obj).removeAttr('disabled');
					$.dialog({
						message : '操作失败',
						timeout : 3,
						type : "error"
					});

				}
			}
		})
	}
	return false;
}

/**
 * 笛卡尔乘积
 * @param object list 对象
 * @returns {*}
 * <code>
 * var result = descartes({'a':['a','b'],'b':[1,2]});
 * 或
 * var result = descartes(['a','b'],[1,2]);
 * alert(result);//result就是笛卡尔积
 * </code>
 */
function descarte(list) {
	//parent上一级索引;count指针计数
	var point = {};
	var result = [];
	var pIndex = null;
	var tempCount = 0;
	var temp = [];
	//根据参数列生成指针对象
	for (var index in list) {
		if ( typeof list[index] == 'object') {
			point[index] = {
				'parent' : pIndex,
				'count' : 0
			}
			pIndex = index;
		}
	}
	//单维度数据结构直接返回
	if (pIndex == null) {
		return list;
	}

	//动态生成笛卡尔积
	while (true) {
		for (var index in list) {
			tempCount = point[index]['count'];
			temp.push(list[index][tempCount]);
		}
		//压入结果数组
		result.push(temp);
		temp = [];
		//检查指针最大值问题
		while (true) {
			if (point[index]['count'] + 1 >= list[index].length) {
				point[index]['count'] = 0;
				pIndex = point[index]['parent'];
				if (pIndex == null) {
					return result;
				}
				//赋值parent进行再次检查
				index = pIndex;
			} else {
				point[index]['count']++;
				break;
			}
		}
	}
}

/**
 * jQuery增强函数
 */
jQuery.extend({
	//过滤空数组
	"array_filter" : function(arr) {
		return $.grep(arr, function(n, i) {
			if ($.trim(n)) {
				return true;
			}
		})
	}
})
/**
 * 异步提交操作
 * @param obj
 * @param url
 * @returns {boolean}
 */
function hd_ajax(requestUrl, postData, url) {
	$.ajax({
		type : "POST",
		url : requestUrl,
		cache : false,
		data : postData || {},
		success : function(data) {
			if (data.substr(0, 1) == '{') {
				data = jQuery.parseJSON(data);
				if (data.state == 1) {
					$.dialog({
						message : data.message,
						timeout : data.timeout || 1,
						type : "success",
						close_handler : function() {
							if (url) {
								location.href = url
							} else {
								window.location.reload(true);
							}
						}
					});
				} else {
					$.dialog({
						message : data.message || "操作失败",
						timeout : data.timeout || 3,
						type : "error"
					});
				}
			} else {
				$.dialog({
					message : '操作失败',
					timeout : 3,
					type : "error"
				});
			}
		}
	})
}

/**
 * 表单提交，有确定按钮，需要点击确定按钮关闭窗口
 * @param obj form表单对象
 * @param url 成功时的跳转url
 * @returns {boolean}
 */
function hd_submit_confirm(obj, url) {
	if ($(obj).is_validate()) {
		var _post = $(obj).serialize();
		$.ajax({
			type : "POST",
			url : $(obj).attr("action"),
			cache : false,
			data : _post,
			success : function(data) {
				if (data.substr(0, 1) == '{') {
					data = jQuery.parseJSON(data);
					if (data.state == 1) {
						$.modal({
							width : 250,
							height : 180,
							title : '温馨提示',
							button_cancel : "关闭",
							message : data.message,
							type : "success",
							//点击确定窗口
							cancel : function() {
								if (url) {
									location.href = url
								} else {
									window.location.reload(true);
								}
							}
						})
					} else {
						$.dialog({
							message : data.message || "操作失败",
							type : "error",
							close_handler : function() {
								location.href = url;
							}
						});
					}
				} else {
					$.dialog({
						message : "操作失败",
						type : "error",
						close_handler : function() {
							location.href = url;
						}
					});
				}
			}
		})
	}
	return false;
}

//＝＝＝＝＝＝加入收藏夹＝＝＝＝＝＝＝＝＝＝＝
function AddFavorite(sURL, sTitle) {
	try {
		window.external.addFavorite(sURL, sTitle);
	} catch (e) {
		try {
			window.sidebar.addPanel(sTitle, sURL, "");
		} catch (e) {
			alert("加入收藏失败，请使用Ctrl+D进行添加");
		}
	}
}

function SetHome(obj, vrl) {
	try {
		obj.style.behavior = 'url(#default#homepage)';
		obj.setHomePage(vrl);
	} catch (e) {
		if (window.netscape) {
			try {
				netscape.security.PRivilegeManager.enablePrivilege("UniversalXPConnect");
			} catch (e) {
				alert("此操作被浏览器拒绝！\n请在浏览器地址栏输入'about:config'并回车\n然后将[signed.applets.codebase_principal_support]设置为'true'");
			}
			var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
			prefs.setCharPref('browser.startup.homepage', vrl);
		}
	}
}

//＝＝＝＝＝＝加入收藏夹＝＝＝＝＝＝＝＝＝＝＝

/**
 * 全选
 * @param element
 */
function select_all(element) {
	$(element).find($("[type='checkbox']")).attr("checked", "checked");
}

/**
 * 反选
 * @param element
 */
function reverse_select(element) {
	$(element).find($("[type='checkbox']")).attr("checked", function() {
		return !$(this).attr("checked") == 1
	});
}

/**
 * 表单验证
 * @category validate
 */

$.fn.extend({
	validate : function(options) {
		//验证的form表单
		var formObj = $(this);
		//验证规则
		var method = {
			//比较两个表单
			"confirm" : function(data) {
				var field = $("[name='" + options[data.name].rule["confirm"] + "']");
				//比较表单内容是否相等
				stat = data.obj.val() == field.val();
				//验证结果处理，提示信息等
				method.call_handler(stat, data);
			},
			//数字
			"num" : function(data) {
				//内容不为空时验证
				if (data.obj.val()) {
					var opt = options[data.name].rule["num"].split(/\s*,\s*/);
					var val = data.obj.val() * 1;
					//验证表单
					stat = val >= opt[0] * 1 && val <= opt[1] * 1;
					//验证结果处理，提示信息等
					method.call_handler(stat, data);
				}
			},
			//验证手机
			"phone" : function(data) {
				//内容不为空时验证
				if (data.obj.val()) {
					//验证表单
					stat = /^\d{11}$/.test(data.obj.val());
					//验证结果处理，提示信息等
					method.call_handler(stat, data);
				}
			},
			//QQ号
			"qq" : function(data) {
				//内容不为空时验证
				if (data.obj.val()) {
					//验证表单
					stat = /^\d{5,10}$/.test(data.obj.val());
					//验证结果处理，提示信息等
					method.call_handler(stat, data);
				}
			},
			//验证固定电话
			"tel" : function(data) {
				//内容不为空时验证
				if (data.obj.val()) {
					//验证表单
					stat = /(?:\(\d{3,4}\)|\d{3,4}-?)\d{8}/.test(data.obj.val());
					//验证结果处理，提示信息等
					method.call_handler(stat, data);
				}
			},
			//验证身份证
			"identity" : function(data) {
				//内容不为空时验证
				if (data.obj.val()) {
					//验证表单
					stat = /^(\d{15}|\d{18})$/.test(data.obj.val());
					//验证结果处理，提示信息等
					method.call_handler(stat, data);
				}
			},
			//网址
			"http" : function(data) {
				//内容不为空时验证
				if (data.obj.val()) {
					//验证表单
					stat = /^(http[s]?:)?(\/{2})?([a-z0-9]+\.)?[a-z0-9]+(\.(com|cn|cc|org|net|com.cn))$/i.test(data.obj.val());
					//验证结果处理，提示信息等
					method.call_handler(stat, data);
				}
			},
			//中文
			"china" : function(data) {
				//内容不为空时验证
				if (data.obj.val()) {
					//验证表单
					stat = /^([^u4e00-u9fa5]|\w)+$/i.test(data.obj.val());
					//验证结果处理，提示信息等
					method.call_handler(stat, data);
				}
			},
			//最小长度
			"minlen" : function(data) {
				//内容不为空时验证
				if (data.obj.val()) {
					//验证表单
					stat = data.obj.val().length >= options[data.name].rule["minlen"];
					//验证结果处理，提示信息等
					method.call_handler(stat, data);
				}
			},
			//最大长度
			"maxlen" : function(data) {
				//内容不为空时验证
				if (data.obj.val()) {
					//验证表单
					stat = data.obj.val().length <= options[data.name].rule["maxlen"];
					//验证结果处理，提示信息等
					method.call_handler(stat, data);
				}
			},
			//正则验证处理
			"regexp" : function(data) {
				if (data.obj.val()) {
					//是否正则对象
					if (options[data.name].rule["regexp"] instanceof RegExp) {
						//是否必须验证
						var reg = options[data.name].rule["regexp"];
						stat = reg.test(data.obj.val());
						//验证结果处理，提示信息等
						method.call_handler(stat, data);
					}
				}
			},
			//验证邮箱
			"email" : function(data) {
				//内容不为空时验证
				if (data.obj.val()) {
					//验证表单
					stat = /^([a-zA-Z0-9_\-\.])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/i.test(data.obj.val());
					//验证结果处理，提示信息等
					method.call_handler(stat, data);
				}
			},
			//验证用户名
			"user" : function(data) {
				if (data.obj.val()) {
					//user: "6,20"  opt为拆分"6,20"
					var opt = options[data.name].rule["user"].split(/\s*,\s*/);
					var reg = new RegExp("^[a-z]\\\w{" + (opt[0] - 1) + "," + (opt[1] - 1) + "}$", "i");
					//验证表单
					stat = reg.test(data.obj.val());
					//验证结果处理，提示信息等
					method.call_handler(stat, data);
				}
			},
			//验证表单是否必须添写
			"required" : function(data) {
				var required = options[data.name].rule["required"];
				//是否必须验证
				if (required) {
					//不为空
					stat = $.trim(data.obj.val()) != "";
					//验证结果处理，提示信息等
					method.call_handler(stat, data);
				} else if (data.obj.val() == '') {//非必填项，当表单内容为空时，清除提示信息
					method.call_handler(true, data);
				}
			},
			"ajax" : function(data) {
				if ($(data.obj).attr('ajax_run'))
					return;
				if (data.obj.attr('ajax_validate') == 1) {
					if (data.send)
						formObj.trigger("submit");
					return;
				}
				//----------------------------------异步提交的参数值--------------------------

				//Ajax验证的参数 Object or String
				var requestData = options[data.name].rule["ajax"];
				var param = {};
				//异步传参
				var url = '';
				//请求的Url
				if ( typeof requestData == 'object') {//传参为对象
					url = requestData.url;
					//请求Url
					param[data.name] = data.obj.val();
					//附加请求参数
					if (requestData['data']) {
						for (var i in requestData['data']) {
							param[i] = requestData['data'][i];
						}
					}
					//附附加字段，有field属性
					if (requestData['field']) {
						for (var i = 0; i < requestData['field'].length; i++) {
							var name = requestData['field'][i];
							param[name] = $("[name='" + name + "']").val();
						}
					}
				} else {
					url = requestData;
					param[data.name] = data.obj.val();
				}
				$(data.obj).attr('ajax_run', 1);
				//----------------------------------异步提交的参数值--------------------------
				//发送异步
				$.ajax({
					url : url,
					cache : false,
					async : true,
					type : 'POST',
					data : param,
					success : function(state) {
						$(data.obj).removeAttr('ajax_run');
						//成功时，如果是提交暂停状态则再次提交
						if (state == 1) {
							//记录验证结果
							data.obj.attr('ajax_validate', 1);
							//验证结果处理，提示信息等
							method.call_handler(1, data);
							//如果是通过submit调用，则提交
							if (data.send) {
								formObj.trigger("submit");
							}
						} else {
							//验证结果处理，提示信息等
							method.call_handler(0, data);
						}
					}
				});
			},
			//调用事件处理程序（设置错误信息）
			call_handler : function(stat, data) {
				var obj = data.obj;
				//表单对象
				$(data.spanObj).removeClass("validate-error validate-success validate-message").html('');
				if (stat) {//验证通过
					//添加表单属性validate
					obj.attr("validate", 1);
					//设置正确提示信息
					var msg = (options[data.name].success || options[data.name].message);
					//如果非必填项，且内容为空时，为没有错误
					if (!data.required && data.obj.val() == '') {
						msg = options[data.name].message || '';
						if (msg)
							$(data.spanObj).addClass("validate-message").html(msg);
					} else if (options[data.name].success) {
						$(data.spanObj).addClass("validate-success").html(msg);
					} else if (msg) {
						$(data.spanObj).addClass("validate-success").html(msg);
					}
				} else {
					//验证失败
					obj.attr("validate", 0);
					//添加表单属性validate
					//设置错误提示信息
					if (options[data.name].error && options[data.name].error[data.rule])
						var msg = (options[data.name].error[data.rule]);
					else
						var msg = "输入错误";
					$(data.spanObj).addClass("validate-error").html(msg);
				}

			},
			/**
			 * 添加验证设置
			 * @param name 表单名
			 * @param spanObj 提示信息span
			 */
			set : function(name, spanObj) {
				//如果没有设置rule属性时，添加rule属性
				if (!options[name].rule) {
					options[name].rule = {};
					options[name].rule.required = false;
				}
				var obj = method.getSpanElement(name);
				//表单
				var fieldObj = obj[0];
				//错误提示信息span对象
				var spanObj = obj[1];
				//设置默认提示信息
				method.setDefaultMessage(name, spanObj);
				//获得焦点时设置默认提示信息
				fieldObj.live("focus", function(event, send) {
					var msg = options[name].message || '';
					if (msg)
						spanObj.removeClass('validate-error validate-success').addClass('validate-message').html(msg);
				})
				//没有设置required必须验证时，默认为不用验证
				options[name].rule.required || (options[name].rule.required = false);
				//默认添加validate属性为1（即成功），必须验证字段设置为0
				if (options[name].rule.required) {
					fieldObj.attr("validate", 0);
				} else {
					fieldObj.attr("validate", 1);
				}
				//密码确认表单，默认为验证失败（必须验证）
				if (options[name]['rule']['confirm']) {
					$(fieldObj).attr("validate", 0);
				}
				//获取表单斛发的事件(blur 或 change)
				fieldObj.live('blur', function(event, send) {
					//如果有Ajax，移除焦点时将validate设为0,否则设置为1
					if (options[name].rule.ajax) {
						fieldObj.attr('ajax_validate', 0);
					}else{
						fieldObj.attr('ajax_validate', 1);
					}
					var required = options[name].rule.required;
					//没有设置required并且内容为空时，验证通过
					if (!required && $(this).val() == '' && !options[name]['rule']['confirm']) {
						$(this).attr('validate', 1).attr('ajax_validate', 1);
						var msg = options[name].message || '';
						if (msg) {
							spanObj.removeClass('validate-error validate-success validate-message').addClass(' validate-message').html(msg);
						} else {
							spanObj.removeClass('validate-error validate-success validate-message').html(msg);
						}
					} else {
						for (var rule in options[name].rule) {
							//验证方法存在
							if (method[rule]) {
								/**
								 * 验证失败 终止验证
								 * 参数说明：
								 * name 表单name属性
								 * obj 表单对象
								 * rule 规则的具体值
								 * send 是否为submit激活的
								 */
								method[rule]({
									event : event,
									name : name,
									obj : fieldObj,
									rule : rule,
									spanObj : spanObj,
									send : send,
									required : required
								});
								if (fieldObj.attr('validate') == 0)
									break;
							}
						}
					}
				});
			},
			/**
			 * 设置默认提示信息
			 * @param name 表单名
			 * @param spanObj 提示信息span
			 */
			setDefaultMessage : function(name, spanObj) {
				var msg = options[name].message;
				if (msg) {
					spanObj.addClass('validate-message').html(msg);
				}
			},
			//获得span提示信息标签
			getSpanElement : function(name) {
				var fieldObj = $("[name='" + name + "']");
				var spanId = "hd_" + name;
				//span提示信息表单的id
				if ($("[id='" + spanId + "']").length == 0) {
					fieldObj.after("<span id='" + spanId + "'></span>");
				}
				spanObj = $("[id='" + spanId + "']");
				return [fieldObj, spanObj];
			}
		};
		//处理事件
		for (var name in options) {
			//验证表单规则
			method.set(name);
		}
		/**
		 * 阻止回车提交表单
		 */
		$(this).keydown(function(event) {
			if (event.keyCode == 13)
				return false;
		})
		/**
		 * 提交验证
		 * action
		 */
		$(this).submit(function(event, action) {
			//如果是通过hd_submit提交时，此方法失效
			if ($(this).attr('hd_submit'))
				return false;
			$('[validate=0]', this).trigger('blur', 'submit');
			$('[ajax_validate=0]', this).trigger('blur', 'submit');
			if ($(this).find("[validate='0']").length == 0 && $(this).find("[ajax_validate='0']").length == 0) {
				return true;
			}
			return false;
		})
	},
	//验证表单
	is_validate : function() {
		$('[validate=0]', this).trigger('blur', 'submit');
		$('[ajax_validate=0]', this).trigger('blur', 'submit');
		if ($(this).find("[validate='0']").length == 0 && $(this).find("[ajax_validate='0']").length == 0) {
			return true;

		}
		return false;
	}
});

