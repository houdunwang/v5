<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>链接列表</title>
    <script type='text/javascript' src='http://localhost/v5/plugin/hd/HDPHP/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/plugin';
		WEB = 'http://localhost/v5/plugin/index.php';
		URL = 'http://localhost/v5/plugin/index.php?g=Plugin&a=Link&c=Manage&m=audit';
		HDPHP = 'http://localhost/v5/plugin/hd/HDPHP/hdphp';
		HDPHPDATA = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Extend';
		APP = 'http://localhost/v5/plugin/index.php?a=Link';
		CONTROL = 'http://localhost/v5/plugin/index.php?a=Link&c=Manage';
		METH = 'http://localhost/v5/plugin/index.php?a=Link&c=Manage&m=audit';
		GROUP = 'http://localhost/v5/plugin/hd';
		TPL = 'http://localhost/v5/plugin/hd/Plugin/Link/Tpl';
		CONTROLTPL = 'http://localhost/v5/plugin/hd/Plugin/Link/Tpl/Manage';
		STATIC = 'http://localhost/v5/plugin/Static';
		PUBLIC = 'http://localhost/v5/plugin/hd/Plugin/Link/Tpl/Public';
		HISTORY = 'http://localhost/v5/plugin/index.php?g=Plugin&a=Link&c=Manage&m=index';
		HTTPREFERER = 'http://localhost/v5/plugin/index.php?g=Plugin&a=Link&c=Manage&m=index';
</script>
    <link type="text/css" rel="stylesheet" href="http://localhost/v5/plugin/hd/static/css/common.css"/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="http://localhost/v5/plugin/index.php?g=Plugin&a=Link&c=Manage&m=index">友情链接</a></li>
            <li><a href="http://localhost/v5/plugin/index.php?g=Plugin&a=Link&c=Manage&m=audit" class="action">审核申请</a></li>
            <li><a href="http://localhost/v5/plugin/index.php?g=Plugin&a=Link&c=Manage&m=add">添加链接</a></li>
            <li><a href="http://localhost/v5/plugin/index.php?g=Plugin&a=Link&c=Type&m=add">添加分类</a></li>
            <li><a href="http://localhost/v5/plugin/index.php?g=Plugin&a=Link&c=Type&m=index">分类管理</a></li>
            <li><a href="http://localhost/v5/plugin/index.php?g=Plugin&a=Link&c=Set&m=set">模块配置</a></li>
        </ul>
    </div>
    <table class="table2 hd-form">
        <thead>
        <tr>
            <td class="w30">id</td>
            <td>网站名称</td>
            <td class="w150">logo</td>
            <td class="w150">站长邮箱</td>
            <td class="w150">站长QQ</td>
            <td class="w100">操作</td>
        </tr>
        </thead>
        <tbody>
        <?php $hd["list"]["l"]["total"]=0;if(isset($link) && !empty($link)):$_id_l=0;$_index_l=0;$lastl=min(1000,count($link));
$hd["list"]["l"]["first"]=true;
$hd["list"]["l"]["last"]=false;
$_total_l=ceil($lastl/1);$hd["list"]["l"]["total"]=$_total_l;
$_data_l = array_slice($link,0,$lastl);
if(count($_data_l)==0):echo "";
else:
foreach($_data_l as $key=>$l):
if(($_id_l)%1==0):$_id_l++;else:$_id_l++;continue;endif;
$hd["list"]["l"]["index"]=++$_index_l;
if($_index_l>=$_total_l):$hd["list"]["l"]["last"]=true;endif;?>

            <tr>
                <td><?php echo $l['id'];?></td>
                <td>
                    <a href="<?php echo $l['url'];?>" target="_blank"><?php echo $l['webname'];?></a>
                </td>
                <td>
                    <img src="http://localhost/v5/plugin/<?php echo $l['logo'];?>" class="h30"/></td>
                <td><?php echo $l['email'];?></td>
                <td><?php echo $l['qq'];?></td>
                <td>
                    <a href="<?php echo $l['url'];?>" target="_blank">查看</a> |
                    <a href="<?php echo U('edit',array('g'=>'Plugin','id'=>$l['id']));?>">编辑</a> |
                    <a href="<?php echo U('del',array('g'=>'Plugin','id'=>$l['id']));?>">删除</a>
                </td>
            </tr>
        <?php $hd["list"]["l"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
        </tbody>
    </table>
</div>
</body>
</html>