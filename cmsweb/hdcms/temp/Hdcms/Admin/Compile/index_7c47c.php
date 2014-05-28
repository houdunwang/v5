<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
		<title>生成首页</title>
		<script type='text/javascript' src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/cmsweb/hdcms';
		WEB = 'http://localhost/v5/cmsweb/hdcms/index.php';
		URL = 'http://localhost/v5/cmsweb/hdcms/a=Admin&c=Cache&m=a=Admin&c=Cache&m=index';
		HDPHP = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp';
		HDPHPDATA = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend';
		APP = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin';
		CONTROL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=Cache';
		METH = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=Cache&m=index';
		GROUP = 'http://localhost/v5/cmsweb/hdcms/hd';
		TPL = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl';
		CONTROLTPL = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/Cache';
		STATIC = 'http://localhost/v5/cmsweb/hdcms/Static';
		PUBLIC = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/Public';
		HISTORY = 'http://localhost/v5/cmsweb/hdcms/a=Admin&c=Cache&m=a=Admin&c=Cache&m=updateCache';
		HTTPREFERER = 'http://localhost/v5/cmsweb/hdcms/a=Admin&c=Cache&m=a=Admin&c=Cache&m=updateCache';
		TEMPLATE = 'http://localhost/v5/cmsweb/hdcms/template/default';
		ROOTURL = 'http://localhost/v5/cmsweb/hdcms';
		WEBURL = 'http://localhost/v5/cmsweb/hdcms/index.php';
		CONTROLURL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=Cache';
</script>
	</head>
	<body>
		<form method="post" action="<?php echo U('index');?>" class="hd-form">
			<div class="wrap">
				<div class="title-header">
					温馨提示
				</div>
				<div class="help">
					首次安装必须更新全站缓存
				</div>
				<div class="title-header">
					更新缓存
				</div>
				<style type="text/css">
					table.table2 td{
						height:35px;
					}
				</style>
				<table class="table1">
					<tr>
						<th class="w100">选择更新</th>
						<td>
						<table class="table2">
							<tr>
								<td><label>
									<input type="checkbox" name="Action[]" value="Config" checked=''/>
									更新网站配置 </label></td>
							</tr>
							<tr>
								<td><label>
									<input type="checkbox" name="Action[]" value="Model" checked=''/>
									内容模型 </label></td>
							</tr>
							<tr>
								<td><label>
									<input type="checkbox" name="Action[]" value="Field" checked=''/>
									模型字段 </label></td>
							</tr>
							<tr>
								<td><label>
									<input type="checkbox" name="Action[]" value="Category" checked=''/>
									栏目缓存 </label></td>
							</tr>
							<tr>
								<td><label>
									<input type="checkbox" name="Action[]" value="Table" checked=''/>
									数据表缓存 </label></td>
							</tr>
							<tr>
								<td><label>
									<input type="checkbox" name="Action[]" value="Node" checked=''/>
									权限节点 </label></td>
							</tr>
							<tr>
								<td><label>
									<input type="checkbox" name="Action[]" value="Role" checked=''/>
									会员角色 </label></td>
							</tr>
							<tr>
								<td><label>
									<input type="checkbox" name="Action[]" value="Flag" checked=''/>
									内容FLAG </label></td>
							</tr>
						</table></td>
					</tr>
				</table>
				<div class="position-bottom">
					<input type="submit" value="开始更新" class="hd-success"/>
				</div>
			</div>
		</form>
	</body>
</html>