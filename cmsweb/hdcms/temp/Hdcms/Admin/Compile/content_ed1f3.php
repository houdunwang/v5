<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>审核内容</title>
    <script type='text/javascript' src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/cmsweb/hdcms';
		WEB = 'http://localhost/v5/cmsweb/hdcms/index.php';
		URL = 'http://localhost/v5/cmsweb/hdcms/index.php?g=Hdcms&a=Admin&c=ContentAudit&m=content&_=0.013322221115231514';
		HDPHP = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp';
		HDPHPDATA = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend';
		APP = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin';
		CONTROL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=ContentAudit';
		METH = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=ContentAudit&m=content';
		GROUP = 'http://localhost/v5/cmsweb/hdcms/hd';
		TPL = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl';
		CONTROLTPL = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/ContentAudit';
		STATIC = 'http://localhost/v5/cmsweb/hdcms/Static';
		PUBLIC = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/Public';
		HISTORY = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin';
		HTTPREFERER = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin';
		TEMPLATE = 'http://localhost/v5/cmsweb/hdcms/template/default';
		ROOTURL = 'http://localhost/v5/cmsweb/hdcms';
		WEBURL = 'http://localhost/v5/cmsweb/hdcms/index.php';
		CONTROLURL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=ContentAudit';
</script>
    <script type="text/javascript" src="http://localhost/v5/cmsweb/hdcms/hd/static/js/js.js"></script>
    <script type="text/javascript" src="http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/ContentAudit/js/content.js"></script>
    <link type="text/css" rel="stylesheet" href="http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/ContentAudit/css/css.css"/>
</head>
<body>
<div class="wrap">
    <form id="search" action="<?php echo U('content');?>" class="hd-form" method="post">
        <div class="search">
            模型：
            <select name="mid" class="w100">
                <?php $hd["list"]["m"]["total"]=0;if(isset($model) && !empty($model)):$_id_m=0;$_index_m=0;$lastm=min(1000,count($model));
$hd["list"]["m"]["first"]=true;
$hd["list"]["m"]["last"]=false;
$_total_m=ceil($lastm/1);$hd["list"]["m"]["total"]=$_total_m;
$_data_m = array_slice($model,0,$lastm);
if(count($_data_m)==0):echo "";
else:
foreach($_data_m as $key=>$m):
if(($_id_m)%1==0):$_id_m++;else:$_id_m++;continue;endif;
$hd["list"]["m"]["index"]=++$_index_m;
if($_index_m>=$_total_m):$hd["list"]["m"]["last"]=true;endif;?>

                <option value="<?php echo $m['mid'];?>" <?php if($mid == $m['mid']){?>selected=''<?php }?>><?php echo $m['model_name'];?></option>
                <?php $hd["list"]["m"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
            </select>
        </div>
    </form>
    <script>
        $("[name='mid'").change(function(){
            $("#search").trigger('submit');
        })
    </script>
    <div class="menu_list">
        <ul>
            <li>
                <a href="<?php echo U('content');?>" class="action">文章列表</a>
            </li>
        </ul>
    </div>
    <table class="table2 hd-form">
        <thead>
        <tr>
            <td class="w30">
                <input type="checkbox" id="select_all"/>
            </td>
            <td class="w30">aid</td>
            <td>标题</td>
            <td class="w100">栏目</td>
            <td class="w100">作者</td>
            <td class="w80">修改时间</td>
            <td class="w50">操作</td>
        </tr>
        </thead>
        <?php $hd["list"]["d"]["total"]=0;if(isset($data) && !empty($data)):$_id_d=0;$_index_d=0;$lastd=min(1000,count($data));
$hd["list"]["d"]["first"]=true;
$hd["list"]["d"]["last"]=false;
$_total_d=ceil($lastd/1);$hd["list"]["d"]["total"]=$_total_d;
$_data_d = array_slice($data,0,$lastd);
if(count($_data_d)==0):echo "";
else:
foreach($_data_d as $key=>$d):
if(($_id_d)%1==0):$_id_d++;else:$_id_d++;continue;endif;
$hd["list"]["d"]["index"]=++$_index_d;
if($_index_d>=$_total_d):$hd["list"]["d"]["last"]=true;endif;?>

            <tr>
                <td><input type="checkbox" name="aid[]" value="<?php echo $d['aid'];?>"/></td>
                <td><?php echo $d['aid'];?></td>
                <td>
                    <a href="<?php echo U('Index/Index/Content',array('mid'=>$mid,'cid'=>$d['cid'],'aid'=>$d['aid']));?>" target="_blank"><?php echo $d['title'];?></a>
                </td>
                <td>
                    <?php echo $d['catname'];?>
                </td>
                <td>
                    <a href="http://localhost/v5/cmsweb/hdcms/index.php?<?php echo $d['uid'];?>" target="_blank"><?php echo $d['username'];?></a>
                    </td>
                <td><?php echo date('Y-m-d',$d['updatetime']);?></td>
                <td>
                    <a href="<?php echo U('Index/Article/show',array('mid'=>$mid,'cid'=>$d['cid'],'aid'=>$d['aid']));?>" target="_blank">
                        访问</a>
                </td>
            </tr>
        <?php $hd["list"]["d"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
    </table>
    <div class="page1">
        <?php echo $page;?>
    </div>
</div>

<div class="position-bottom">
    <input type="button" class="hd-cancel" value="全选" onclick="select_all('.table2')"/>
    <input type="button" class="hd-cancel" value="反选" onclick="reverse_select('.table2')"/>
    <input type="button" class="hd-cancel" onclick="del()" value="批量删除"/>
    <input type="button" class="hd-cancel" onclick="audit(<?php echo $mid;?>,1)" value="审核"/>
</div>
</body>
</html>