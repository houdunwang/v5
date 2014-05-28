<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>友情链接配置</title>
    <script type='text/javascript' src='http://localhost/v5/plugin/hd/HDPHP/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/plugin';
		WEB = 'http://localhost/v5/plugin/index.php';
		URL = 'http://localhost/v5/plugin/index.php?g=Plugin&a=Link&c=Set&m=set';
		HDPHP = 'http://localhost/v5/plugin/hd/HDPHP/hdphp';
		HDPHPDATA = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Extend';
		APP = 'http://localhost/v5/plugin/index.php?a=Link';
		CONTROL = 'http://localhost/v5/plugin/index.php?a=Link&c=Set';
		METH = 'http://localhost/v5/plugin/index.php?a=Link&c=Set&m=set';
		GROUP = 'http://localhost/v5/plugin/hd';
		TPL = 'http://localhost/v5/plugin/hd/Plugin/Link/Tpl';
		CONTROLTPL = 'http://localhost/v5/plugin/hd/Plugin/Link/Tpl/Set';
		STATIC = 'http://localhost/v5/plugin/Static';
		PUBLIC = 'http://localhost/v5/plugin/hd/Plugin/Link/Tpl/Public';
		HISTORY = 'http://localhost/v5/plugin/index.php?g=Plugin&a=Link&c=Type&m=add';
		HTTPREFERER = 'http://localhost/v5/plugin/index.php?g=Plugin&a=Link&c=Type&m=add';
</script>
    <link type="text/css" rel="stylesheet" href="http://localhost/v5/plugin/hd/static/css/common.css"/>
    <script type="text/javascript" src="http://localhost/v5/plugin/hd/Plugin/Link/Tpl/Set/js/set.js"></script>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="http://localhost/v5/plugin/index.php?g=Plugin&a=Link&c=Manage&m=index">友情链接</a></li>
            <li><a href="http://localhost/v5/plugin/index.php?g=Plugin&a=Link&c=Manage&m=audit">审核申请</a></li>
            <li><a href="http://localhost/v5/plugin/index.php?g=Plugin&a=Link&c=Manage&m=add">添加链接</a></li>
            <li><a href="http://localhost/v5/plugin/index.php?g=Plugin&a=Link&c=Type&m=add">添加分类</a></li>
            <li><a href="http://localhost/v5/plugin/index.php?g=Plugin&a=Link&c=Type&m=index">分类管理</a></li>
            <li><a href="http://localhost/v5/plugin/index.php?g=Plugin&a=Link&c=Set&m=set" class="action">模块配置</a></li>
        </ul>
    </div>
    <form action="" method="post" class="hd-form" enctype="multipart/form-data">
        <div class="title-header">网站信息</div>
        <table class="table1">
            <tr>
                <th class="w100">网站名称</th>
                <td>
                    <input type="text" name="webname" value="<?php echo $field['webname'];?>" class="w200"/>
                </td>
            </tr>
            <tr>
                <th class="w100">网址</th>
                <td>
                    <input type="text" name="url" value="<?php echo $field['url'];?>" class="w200"/>
                </td>
            </tr>
            <tr>
                <th class="w100">站长邮箱</th>
                <td>
                    <input type="text" name="email" value="<?php echo $field['email'];?>" class="w200"/>
                </td>
            </tr>
            <tr>
                <th class="w100">联系QQ</th>
                <td>
                    <input type="text" name="qq" value="<?php echo $field['qq'];?>" class="w200"/>
                </td>
            </tr>
            <tr>
                <th class="w100">LOGO</th>
                <td>
                    <input type="file" name="logo"/>
                    <img src="http://localhost/v5/plugin/<?php echo $field['logo'];?>" alt="网站LOGO" class="h50"/>
                </td>
            </tr>
            <tr>
                <th>申请说明</th>
                <td>
                    <textarea name="comment" class="w400 h120"><?php echo $field['comment'];?></textarea>
                </td>
            </tr>
        </table>
        <div class="title-header">申请配置</div>
        <table class="table1">
            <tr>
                <th class="w100">开放申请</th>
                <td>
                    <label><input type="radio" name="allow" value="1" <?php if($field['allow'] == 1){?>checked="checked"<?php }?>/> 是</label>
                    <label><input type="radio" name="allow" value="0" <?php if($field['allow'] == 0){?>checked="checked"<?php }?>/> 否</label>
                </td>
            </tr>
            <tr>
                <th class="w100">开启验证码</th>
                <td>
                    <label><input type="radio" name="code" value="1" <?php if($field['code'] == 1){?>checked="checked"<?php }?>/> 是</label>
                    <label><input type="radio" name="code" value="0" <?php if($field['code'] == 0){?>checked="checked"<?php }?>/> 否</label>
                </td>
            </tr>
        </table>
        <div class="position-bottom">
            <input type="submit" value="确定" class="hd-success"/>
        </div>
    </form>
</div>
</body>
</html>