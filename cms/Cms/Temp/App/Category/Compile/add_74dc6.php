<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><html>
<head>
	<title>添加栏目</title>
	<script type='text/javascript' src='http://localhost/v5/cms/hdphp/hdphp/../hdjs/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/cms/hdphp/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/cms/hdphp/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/cms/hdphp/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/cms/hdphp/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/cms';
		WEB = 'http://localhost/v5/cms/index.php';
		URL = 'http://localhost/v5/cms/index.php/Category/Category&m=add&pid=8';
		HDPHP = 'http://localhost/v5/cms/hdphp/hdphp';
		HDPHPDATA = 'http://localhost/v5/cms/hdphp/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/cms/hdphp/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/cms/hdphp/hdphp/Extend';
		APP = 'http://localhost/v5/cms/index.php/Category';
		CONTROL = 'http://localhost/v5/cms/index.php/Category/Category';
		METH = 'http://localhost/v5/cms/index.php/Category/Category/add';
		GROUP = 'http://localhost/v5/cms/Cms';
		TPL = 'http://localhost/v5/cms/Cms/App/Category/Tpl';
		CONTROLTPL = 'http://localhost/v5/cms/Cms/App/Category/Tpl/Category';
		STATIC = 'http://localhost/v5/cms/Static';
		PUBLIC = 'http://localhost/v5/cms/Cms/App/Category/Tpl/Public';
</script>
	<script type="text/javascript" src="http://localhost/v5/cms/Cms/App/Category/Tpl/Category/js/validate.js"></script>
	<script type="text/javascript" src="http://localhost/v5/cms/Cms/App/Category/Tpl/Category/js/js.js"></script>
</head>
<body>
<div class="menu_list">
	<ul>
		 <li><a href="<?php echo U('index');?>" > 栏目列表 </a></li>
		 <li><a href="#"> 更新栏目缓存 </a></li>
	</ul>
</div>
<div class='title-header'>添加栏目</div>
<form method='post'  class='hd-form' onsubmit="return hd_submit(this,'<?php echo U(index);?>')">
	<table class='table1'>
		<tr>
			<th class='w100'>栏目名称</th>
			<td>
				<input type='text' name='cname' class='w200'/>
			</td>
		</tr>
		<tr>
			<th class='w100'>关键字</th>
			<td>
				<input type='text' name='keywords' class='w300'/>
			</td>
		</tr>
		<tr>
			<th class='w100'>栏目描述</th>
			<td>
				<textarea name='description' class='w300 h100'></textarea>
			</td>
		</tr>
	</table>
	<div class='position-bottom'>
		<input type='submit' value='确定' class='hd-success'/>
	</div>
</form>
</body>
</html>