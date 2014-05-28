<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>HDCMS - 后台管理中心</title>
    <script type='text/javascript' src='http://localhost/v5/plugin/hd/HDPHP/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/plugin';
		WEB = 'http://localhost/v5/plugin/index.php';
		URL = 'http://localhost/v5/plugin/index.php?a=Admin';
		HDPHP = 'http://localhost/v5/plugin/hd/HDPHP/hdphp';
		HDPHPDATA = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Extend';
		APP = 'http://localhost/v5/plugin/index.php?a=Admin';
		CONTROL = 'http://localhost/v5/plugin/index.php?a=Admin&c=Index';
		METH = 'http://localhost/v5/plugin/index.php?a=Admin&c=Index&m=index';
		GROUP = 'http://localhost/v5/plugin/hd';
		TPL = 'http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl';
		CONTROLTPL = 'http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Index';
		STATIC = 'http://localhost/v5/plugin/Static';
		PUBLIC = 'http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Public';
		HISTORY = 'http://localhost/v5/plugin/index.php?a=Admin';
		HTTPREFERER = 'http://localhost/v5/plugin/index.php?a=Admin';
</script>
    <script type="text/javascript" src="http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Index/js/menu.js"></script>
    <script type="text/javascript" src="http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Index/js/quick_menu.js"></script>
    <link type="text/css" rel="stylesheet" href="http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Index/css/css.css"/>
    <link type="text/css" rel="stylesheet" href="http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Index/css/quick_menu.css"/>
</head>
<body>
<div class="nav">
    <!--头部左侧导航-->
    <div class="top_menu">
        <?php $hd["list"]["m"]["total"]=0;if(isset($top_menu) && !empty($top_menu)):$_id_m=0;$_index_m=0;$lastm=min(1000,count($top_menu));
$hd["list"]["m"]["first"]=true;
$hd["list"]["m"]["last"]=false;
$_total_m=ceil($lastm/1);$hd["list"]["m"]["total"]=$_total_m;
$_data_m = array_slice($top_menu,0,$lastm);
if(count($_data_m)==0):echo "";
else:
foreach($_data_m as $key=>$m):
if(($_id_m)%1==0):$_id_m++;else:$_id_m++;continue;endif;
$hd["list"]["m"]["index"]=++$_index_m;
if($_index_m>=$_total_m):$hd["list"]["m"]["last"]=true;endif;?>

            <a href="javascript:" nid="<?php echo $m['nid'];?>" onclick="get_left_menu(<?php echo $m['nid'];?>);" class="top_menu"><?php echo $m['title'];?></a>
        <?php $hd["list"]["m"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
    </div>
    <!--头部左侧导航-->
    <!--头部右侧导航-->
    <div class="r_menu">
        <?php echo $_SESSION['rname'];?> : <?php echo $_SESSION['username'];?> <a href="<?php echo U('Login/out');?>" target="_self">[退出]</a>
        <span>|</span>
        <a href="javascript:hd_ajax('<?php echo U('updateAllCache');?>');">更新全站缓存</a>
        <span>|</span>
        <a href="http://localhost/v5/plugin/index.php" target="_blank">前台首页</a>
        <span>|</span>
        <a href="<?php echo U('Member/Index/index');?>" target="_blank">会员中心</a>
    </div>
    <!--头部右侧导航-->
</div>
<!--左侧导航-->
<div class="main">
    <!--主体左侧导航-->
    <div class="left_menu"></div>
    <!--主体左侧导航-->
    <!--内容显示区域-->
    <div class="menu_nav">
        <div class="direction">
            <a href="#" class="left">向左</a>
            <a href="#" class="right">向右</a>
        </div>
        <div class="favorite_menu">
            <ul>
                <li class="action" nid="0" style="border-left:solid 1px #D8D8D8;"><a href="javascript:;" class="menu" nid="0">环境</a></li>
            </ul>
        </div>
    </div>
    <div class="top_content">
        <iframe src="<?php echo U('welcome');?>" nid="0" scrolling="auto" frameborder="0"
                style="height: 100%;width: 100%;"></iframe>
    </div>
    <!--内容显示区域-->
</div>
<div id="quick_menu">
    <div class="set">
        <a url="<?php echo U('setFavorite');?>" onclick="get_content(this,90001)" href="javascript:;" nid="90001">设置</a>
    </div>
    <div
        style="float:left;width:1px;margin-right:5px;overflow: hidden;background: #999999;height:15px;margin-top:12px;"></div>
    <div class="bottom-menu">
        <?php $hd["list"]["f"]["total"]=0;if(isset($favorite_menu) && !empty($favorite_menu)):$_id_f=0;$_index_f=0;$lastf=min(1000,count($favorite_menu));
$hd["list"]["f"]["first"]=true;
$hd["list"]["f"]["last"]=false;
$_total_f=ceil($lastf/1);$hd["list"]["f"]["total"]=$_total_f;
$_data_f = array_slice($favorite_menu,0,$lastf);
if(count($_data_f)==0):echo "";
else:
foreach($_data_f as $key=>$f):
if(($_id_f)%1==0):$_id_f++;else:$_id_f++;continue;endif;
$hd["list"]["f"]["index"]=++$_index_f;
if($_index_f>=$_total_f):$hd["list"]["f"]["last"]=true;endif;?>

            <a url="?a=<?php echo $f['app'];?>&c=<?php echo $f['control'];?>&m=<?php echo $f['method'];?>&nid=<?php echo $f['nid'];?>"
               onclick="get_content(this,<?php echo $f['nid'];?>)" href="javascript:;" nid="<?php echo $f['nid'];?>"><?php echo $f['title'];?></a>
        <?php $hd["list"]["f"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
    </div>
    <div class="quick-hide">
        <a href="javascript:quick_menu_hide();">隐藏</a>
    </div>
</div>
<div id="show_quick_menu" onclick="show_quick_menu()">
    显示
</div>
<!--加载后触发第一个顶级菜单-->
<script>
    $("a[nid=1]").trigger("click");
</script>
</body>
</html>