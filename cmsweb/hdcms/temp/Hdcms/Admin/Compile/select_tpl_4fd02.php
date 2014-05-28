<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>选择模板</title>
    <script type='text/javascript' src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/cmsweb/hdcms';
		WEB = 'http://localhost/v5/cmsweb/hdcms/index.php';
		URL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=TemplateSelect&m=select_tpl&name=index_tpl';
		HDPHP = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp';
		HDPHPDATA = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend';
		APP = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin';
		CONTROL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=TemplateSelect';
		METH = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=TemplateSelect&m=select_tpl';
		GROUP = 'http://localhost/v5/cmsweb/hdcms/hd';
		TPL = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl';
		CONTROLTPL = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/TemplateSelect';
		STATIC = 'http://localhost/v5/cmsweb/hdcms/Static';
		PUBLIC = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/Public';
		HISTORY = 'http://localhost/v5/cmsweb/hdcms/a=Admin&c=Category&m=edit&cid=13';
		HTTPREFERER = 'http://localhost/v5/cmsweb/hdcms/a=Admin&c=Category&m=edit&cid=13';
		TEMPLATE = 'http://localhost/v5/cmsweb/hdcms/template/default';
		ROOTURL = 'http://localhost/v5/cmsweb/hdcms';
		WEBURL = 'http://localhost/v5/cmsweb/hdcms/index.php';
		CONTROLURL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=TemplateSelect';
</script>
    <script type="text/javascript" src="http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/TemplateSelect/js/select_tpl.js"></script>
    <link type="text/css" rel="stylesheet" href="http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/TemplateSelect/css/select_tpl.css"/>
    <script type="text/javascript" charset="utf-8">
    	var fieldName ="<?php echo $_GET['name'];?>" ;
    </script>
</head>
<body>
<div id="select_tpl" style="overflow-y: auto;height:315px;">
    
</div>
<script type="text/javascript" charset="utf-8">
	$(function(){
		getFileList('<?php echo U('getFileList');?>');
	});
</script>
</body>
</html>