<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><html>
<head>
	<title>后台登录入口</title>
	<script type='text/javascript' src='http://localhost/v5/cms/hdphp/hdphp/../hdjs/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/cms/hdphp/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/cms/hdphp/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/cms/hdphp/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/cms/hdphp/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/cms';
		WEB = 'http://localhost/v5/cms/index.php';
		URL = 'http://localhost/v5/cms/index.php/v5/login/login';
		HDPHP = 'http://localhost/v5/cms/hdphp/hdphp';
		HDPHPDATA = 'http://localhost/v5/cms/hdphp/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/cms/hdphp/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/cms/hdphp/hdphp/Extend';
		APP = 'http://localhost/v5/cms/index.php/V5';
		CONTROL = 'http://localhost/v5/cms/index.php/V5/Login';
		METH = 'http://localhost/v5/cms/index.php/V5/Login/login';
		GROUP = 'http://localhost/v5/cms/Cms/';
		TPL = 'http://localhost/v5/cms/Cms/App/V5/Tpl';
		CONTROLTPL = 'http://localhost/v5/cms/Cms/App/V5/Tpl/Login';
		STATIC = 'http://localhost/v5/cms/Static';
		PUBLIC = 'http://localhost/v5/cms/Cms/App/V5/Tpl/Public';
</script>
	<link href="http://localhost/v5/cms/hdphp/hdphp/Extend/Org/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"><script src="http://localhost/v5/cms/hdphp/hdphp/Extend/Org/bootstrap/js/bootstrap.min.js"></script>
  <!--[if lte IE 6]>
  <link rel="stylesheet" type="text/css" href="http://localhost/v5/cms/hdphp/hdphp/Extend/Org/bootstrap/ie6/css/bootstrap-ie6.css">
  <![endif]-->
  <!--[if lte IE 7]>
  <link rel="stylesheet" type="text/css" href="http://localhost/v5/cms/hdphp/hdphp/Extend/Org/bootstrap/ie6/css/ie.css">
  <![endif]-->
	<script type="text/javascript" src="http://localhost/v5/cms/Cms/App/V5/Tpl/Login/js/js.js"></script>
</head>
<body>
<h3>管理员登录</h3>
<form method='post' class='hd-form'>	
<table class='table1'>
	<tr>
 		<td class='w100'>帐号</td>
 		<td>
 			<input type='text' name='username'/>
 		</td>
	</tr>
	<tr>
 		<td>密码</td>
 		<td>
 			<input type='password' name='password'/>
 		</td>
	</tr>
	<tr>
 		<td>验证码</td>
 		<td>
 			<input type='text' name='code'/>
 			<img src='http://localhost/v5/cms/index.php/V5/Login/code'/>
 			<span id='hd_code'></span>
 		</td>
	</tr>
	<tr>
 		<td colspan='2'>
 			<input type='submit' value='登录' class='btn btn-primary'/>
 		</td>
	</tr>
</table>
</form>
</body>
</html>