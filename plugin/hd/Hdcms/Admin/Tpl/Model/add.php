<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>添加模型</title>
    <hdjs/>
</head>
<body>
<form action="{|U:'add'}" method="post" class="hd-form" onsubmit="return hd_submit(this,'{|U:index}')">
    <div class="wrap">
        <div class="menu_list">
            <ul>
                <li><a href="{|U:'index'}">模型列表</a></li>
                <li><a href="javascript:;" class="action">添加模型</a></li>
            </ul>
        </div>
        <div class="title-header">温馨提示</div>
        <div class="help">
            <ul>
                <li>自定义模型对于新手来讲，不太好理解。请登录<a href="http://www.hdphp.com" target="_blank">hdphp.com</a>下载视频学习</li>
            </ul>
        </div>
        <div class="title-header">
           	 添加模型
        </div>
        <div class="right_content">
            <table class="table1">
                <tr>
                    <th class="w100">模型名称</th>
                    <td>
                        <input type="text" name="model_name" class="w200"/>
                    </td>
                </tr>
                <tr>
                    <th>表名</th>
                    <td>
                        <input type="text" name="table_name" class="w200"/>
                    </td>
                </tr>
                <tr>
                    <th>模型描述</th>
                    <td>
                        <textarea name="description" class="w350 h80"></textarea>
                    </td>
                </tr>
                </table>
        </div>
    </div>
    <div class="position-bottom">
        <input type="submit" value="确定" class="hd-success"/>
    </div>
</form>
<script>
	$("form").validate({
		title:{
			rule:{required:true},
			error:{required:'不能为空'}
		},
		table_name:{
			rule:{required:true,regexp:/[a-z0-9]+/},
			error:{required:'不能为空',regexp:'输入字母'}
		}
	});
</script>
</body>
</html>