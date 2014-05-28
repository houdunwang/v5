<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>插件安装</title>
    <script type='text/javascript' src='http://localhost/v5/plugin/hd/HDPHP/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/plugin';
		WEB = 'http://localhost/v5/plugin/index.php';
		URL = 'http://localhost/v5/plugin/index.php?a=Admin&c=Plugin&m=install&plugin=Mood';
		HDPHP = 'http://localhost/v5/plugin/hd/HDPHP/hdphp';
		HDPHPDATA = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Extend';
		APP = 'http://localhost/v5/plugin/index.php?a=Admin';
		CONTROL = 'http://localhost/v5/plugin/index.php?a=Admin&c=Plugin';
		METH = 'http://localhost/v5/plugin/index.php?a=Admin&c=Plugin&m=install';
		GROUP = 'http://localhost/v5/plugin/hd';
		TPL = 'http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl';
		CONTROLTPL = 'http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Plugin';
		STATIC = 'http://localhost/v5/plugin/Static';
		PUBLIC = 'http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Public';
		HISTORY = 'http://localhost/v5/plugin/index.php?g=Hdcms&a=Admin&c=Plugin&m=plugin_list&_=0.2527525422628969';
		HTTPREFERER = 'http://localhost/v5/plugin/index.php?g=Hdcms&a=Admin&c=Plugin&m=plugin_list&_=0.2527525422628969';
</script>
    <script type="text/javascript" src="http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Index/js/menu.js"></script>
    <script type="text/javascript" src="http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Plugin/js/js.js"></script>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li>
                <a href="http://localhost/v5/plugin/index.php?a=Admin&c=Plugin&m=plugin_list">插件列表</a>
            </li>
            <li>
                <a class="action" href="javascript:;">安装插件</a>
            </li>
        </ul>
    </div>
    <div class="title-header">安装插件</div>
    <form method="post" onsubmit="return false;">
        <input type="hidden" name="plugin" value="<?php echo $field['plugin'];?>"/>
        <table class="table1 hd-form">
            <tr>
                <th class="w150">插件名称</th>
                <td><?php echo $field['name'];?></td>
            </tr>
            <tr>
                <th>插件版本</th>
                <td><?php echo $field['version'];?></td>
            </tr>
            <tr>
                <th>团队名称</th>
                <td><?php echo $field['team'];?></td>
            </tr>
            <tr>
                <th>发布时间</th>
                <td><?php echo $field['pubdate'];?></td>
            </tr>
            <tr>
                <th>网站</th>
                <td><?php echo $field['web'];?></td>
            </tr>
            <tr>
                <th>电子邮箱</th>
                <td><?php echo $field['email'];?></td>
            </tr>
        </table>
        <div class="position-bottom">
            <input type="submit" value="安装" class="hd-success"/>
        </div>
    </form>
</div>
</body>
</html>