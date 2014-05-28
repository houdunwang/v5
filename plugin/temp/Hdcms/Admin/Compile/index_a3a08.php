<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>模型字段管理</title>
    <script type='text/javascript' src='http://localhost/v5/plugin/hd/HDPHP/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/plugin';
		WEB = 'http://localhost/v5/plugin/index.php';
		URL = 'http://localhost/v5/plugin/index.php?a=Admin&c=Field&m=index&mid=1';
		HDPHP = 'http://localhost/v5/plugin/hd/HDPHP/hdphp';
		HDPHPDATA = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Extend';
		APP = 'http://localhost/v5/plugin/index.php?a=Admin';
		CONTROL = 'http://localhost/v5/plugin/index.php?a=Admin&c=Field';
		METH = 'http://localhost/v5/plugin/index.php?a=Admin&c=Field&m=index';
		GROUP = 'http://localhost/v5/plugin/hd';
		TPL = 'http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl';
		CONTROLTPL = 'http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Field';
		STATIC = 'http://localhost/v5/plugin/Static';
		PUBLIC = 'http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Public';
		HISTORY = 'http://localhost/v5/plugin/index.php?a=Admin&c=Field&m=index&mid=1';
		HTTPREFERER = 'http://localhost/v5/plugin/index.php?a=Admin&c=Field&m=index&mid=1';
</script>
    <link type="text/css" rel="stylesheet" href="http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Field/css/css.css"/>
    <script type="text/javascript" src="http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Field/js/js.js"></script>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="<?php echo U('Model/index');?>">模型列表</a></li>
            <li><a href="javascript:;" class="action">字段列表</a></li>
            <li><a href="<?php echo U('add',array('mid'=>$_GET['mid']));?>">添加字段</a></li>
            <li><a href="javascript:;" onclick="hd_ajax('<?php echo U(updateCache);?>',{mid:<?php echo $_GET['mid'];?>})">更新缓存</a></li>
        </ul>
    </div>
    <table class="table2 hd-form">
        <thead>
        <tr>
            <td class="w50">排序</td>
            <td class="w50">Fid</td>
            <td class="w200">描述</td>
            <td>字段名</td>
            <td class="w200">表名</td>
            <td class="w100">类型</td>
            <td class="w80">系统</td>
            <td class="w80">必填</td>
            <td class="w80">搜索</td>
            <td class="w80">投稿</td>
            <td class="w120">操作&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
        </tr>
        </thead>
        <tbody>
        <?php $hd["list"]["f"]["total"]=0;if(isset($field) && !empty($field)):$_id_f=0;$_index_f=0;$lastf=min(1000,count($field));
$hd["list"]["f"]["first"]=true;
$hd["list"]["f"]["last"]=false;
$_total_f=ceil($lastf/1);$hd["list"]["f"]["total"]=$_total_f;
$_data_f = array_slice($field,0,$lastf);
if(count($_data_f)==0):echo "";
else:
foreach($_data_f as $key=>$f):
if(($_id_f)%1==0):$_id_f++;else:$_id_f++;continue;endif;
$hd["list"]["f"]["index"]=++$_index_f;
if($_index_f>=$_total_f):$hd["list"]["f"]["last"]=true;endif;?>

            <tr>
                <td>
                    <input type="text" name="fieldsort[<?php echo $f['fid'];?>]" class="w30" value="<?php echo $f['fieldsort'];?>"/>
                </td>
                <td>
                    <?php echo $f['fid'];?>
                </td>
                <td><?php echo $f['title'];?></td>
                <td><?php echo $f['field_name'];?></td>
                <td><?php echo $f['table_name'];?></td>
                <td><?php echo $f['field_type'];?></td>
                <td>
                    <?php if($f['is_system']){?>
                    	<font color="red">√</font>
                        <?php  }else{ ?><font color="blue">×</font>
                    <?php }?>
                </td>
                <td>
                    <?php if($f['required']){?>
                    	<font color="red">√</font>
                        <?php  }else{ ?><font color="blue">×</font>
                    <?php }?>
                </td>
                <td>
                    <?php if($f['issearch']){?>
                    	<font color="red">√</font>
                        <?php  }else{ ?><font color="blue">×</font>
                    <?php }?>
                </td>
                <td>
                    <?php if($f['isadd']){?>
                    	<font color="red">√</font>
                        <?php  }else{ ?><font color="blue">×</font>
                    <?php }?>
                </td>
                <td>
                	 <a href="<?php echo U('edit',array('mid'=>$f['mid'],'fid'=>$f['fid']));?>">修改</a>       
                	 |
                	 <?php if(in_array($f['field_name'],$noallowforbidden)){?>
                	 	<span style='color:#666'>禁用</span>
                	 	<?php }else if($f['field_state']==1){?>
                   <a href="javascript:hd_ajax('<?php echo U(forbidden);?>',{fid:<?php echo $f['fid'];?>,field_state:0,mid:<?php echo $f['mid'];?>})" >禁用</a>             
                   		<?php }else{?>
                   		<a href="javascript:hd_ajax('<?php echo U(forbidden);?>',{fid:<?php echo $f['fid'];?>,field_state:1,mid:<?php echo $f['mid'];?>},'http://localhost/v5/plugin/index.php?a=Admin&c=Field&m=index&mid=1')" style='color:red'>启用</a>			
                   			<?php }?>
                    |
                    <?php if(in_array($f['field_name'],$noallowdelete)):?>
                			<span style='color:#666'>删除</span>
                	<?php else:?>
                		 <a href="javascript:"
                       onclick="return confirm('确定删除【<?php echo $f['title'];?>】字段吗？')?hd_ajax('<?php echo U(del);?>',{mid:<?php echo $f['mid'];?>,fid:<?php echo $f['fid'];?>}):false;">删除</a>
                	<?php endif;?>
                   
                </td>
            </tr>
        <?php $hd["list"]["f"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
        </tbody>
    </table>
    <div class="position-bottom">
        <input type="button" class="hd-success" onclick="update_sort(<?php echo $_GET['mid'];?>);" value="排序"/>
    </div>
</div>
</body>
</html>