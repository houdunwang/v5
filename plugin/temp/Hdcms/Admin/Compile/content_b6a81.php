<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
		<title>内容列表</title>
		<script type='text/javascript' src='http://localhost/v5/plugin/hd/HDPHP/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/plugin';
		WEB = 'http://localhost/v5/plugin/index.php';
		URL = 'http://localhost/v5/plugin/index.php?a=Admin&c=Content&m=content&cid=2&mid=1';
		HDPHP = 'http://localhost/v5/plugin/hd/HDPHP/hdphp';
		HDPHPDATA = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Extend';
		APP = 'http://localhost/v5/plugin/index.php?a=Admin';
		CONTROL = 'http://localhost/v5/plugin/index.php?a=Admin&c=Content';
		METH = 'http://localhost/v5/plugin/index.php?a=Admin&c=Content&m=content';
		GROUP = 'http://localhost/v5/plugin/hd';
		TPL = 'http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl';
		CONTROLTPL = 'http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Content';
		STATIC = 'http://localhost/v5/plugin/Static';
		PUBLIC = 'http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Public';
		HISTORY = 'http://localhost/v5/plugin/index.php?g=Hdcms&a=Admin&c=Content&m=index&_=0.5281800061929971';
		HTTPREFERER = 'http://localhost/v5/plugin/index.php?g=Hdcms&a=Admin&c=Content&m=index&_=0.5281800061929971';
</script>
		<script type="text/javascript" src="http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Content/js/content.js"></script>
		<link type="text/css" rel="stylesheet" href="http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Content/css/css.css"/>
	</head>
	<body>
		<div class="wrap">
			<form action="<?php echo U('content',array('mid'=>$_GET['mid'],'cid'=>$_GET['cid']));?>" class="hd-form" method="post">
				<input type="hidden" name="m" value="content"/>
				<input type="hidden" name="mid" value="<?php echo $_GET['mid'];?>"/>
				<input type="hidden" name="cid" value="<?php echo $_GET['cid'];?>"/>
				<input type="hidden" name="state" value="<?php echo $_GET['state'];?>"/>
				<div class="search">
					添加时间：
					<input id="begin_time" placeholder="开始时间" readonly="readonly" class="w80" type="text" value="" name="search_begin_time">
					<script>
						$('#begin_time').calendar({
							format : 'yyyy-MM-dd'
						});
					</script>
					-
					<input id="end_time" placeholder="结束时间" readonly="readonly" class="w80" type="text" value="" name="search_end_time">
					<script>
						$('#end_time').calendar({
							format : 'yyyy-MM-dd'
						});
					</script>
					&nbsp;&nbsp;&nbsp;
					<select name="flag" class="w100">
						<option selected="" value="">全部</option>
						<?php $hd["list"]["f"]["total"]=0;if(isset($flag) && !empty($flag)):$_id_f=0;$_index_f=0;$lastf=min(1000,count($flag));
$hd["list"]["f"]["first"]=true;
$hd["list"]["f"]["last"]=false;
$_total_f=ceil($lastf/1);$hd["list"]["f"]["total"]=$_total_f;
$_data_f = array_slice($flag,0,$lastf);
if(count($_data_f)==0):echo "";
else:
foreach($_data_f as $key=>$f):
if(($_id_f)%1==0):$_id_f++;else:$_id_f++;continue;endif;
$hd["list"]["f"]["index"]=++$_index_f;
if($_index_f>=$_total_f):$hd["list"]["f"]["last"]=true;endif;?>

							<option value="<?php echo $f;?>" <?php if($_POST['flag'] == $f){?>selected=''<?php }?>><?php echo $f;?></option>
						<?php $hd["list"]["f"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
					</select>
					&nbsp;&nbsp;&nbsp;
					<select name="search_type" class="w100">
						<option value="1" <?php if($_GET['search_type'] == 1){?>selected=''<?php }?>>标题</option>
						<option value="2" <?php if($_GET['search_type'] == 2){?>selected=''<?php }?>>简介</option>
						<option value="3" <?php if($_GET['search_type'] == 3){?>selected=''<?php }?>>用户名</option>
						<option value="4" <?php if($_GET['search_type'] == 4){?>selected=''<?php }?>>用户uid</option>
					</select>&nbsp;&nbsp;&nbsp;
					关键字：
					<input class="w200" type="text" placeholder="请输入关键字..." value="<?php echo $_POST['search_keyword'];?>" name="search_keyword">
					<button class="hd-cancel" type="submit">
						搜索
					</button>
				</div>
			</form>
			<div class="menu_list">
				<ul>
					<li>
						<a href="<?php echo U('content',array('mid'=>$_GET['mid'],'cid'=>$_GET['cid'],'state'=>1));?>"
						<?php if($_GET['state']==1){?>class="action"<?php }?> >
							内容列表
						</a>
					</li>

					<li>
						<a href="<?php echo U('content',array('mid'=>$_GET['mid'],'cid'=>$_GET['cid'],'state'=>0));?>"
						<?php if($_GET['content_state']==0){?>class="action"<?php }?> >
							未审核
						</a>
					</li>
					<li>
						<a href="javascript:;" onclick="hd_open_window('<?php echo U(add,array('cid'=>$_GET['cid'],'mid'=>$_GET['mid']));?>')">
							添加内容
						</a>
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
						<td class="w30">cid</td>
						<td class="w30">排序</td>
						<td>标题</td>
						<td class="w50">状态</td>
						<td class="w100">作者</td>
						<td class="w80">修改时间</td>
						<td class="w120">操作</td>
					</tr>
				</thead>
				<?php $hd["list"]["c"]["total"]=0;if(isset($data) && !empty($data)):$_id_c=0;$_index_c=0;$lastc=min(1000,count($data));
$hd["list"]["c"]["first"]=true;
$hd["list"]["c"]["last"]=false;
$_total_c=ceil($lastc/1);$hd["list"]["c"]["total"]=$_total_c;
$_data_c = array_slice($data,0,$lastc);
if(count($_data_c)==0):echo "";
else:
foreach($_data_c as $key=>$c):
if(($_id_c)%1==0):$_id_c++;else:$_id_c++;continue;endif;
$hd["list"]["c"]["index"]=++$_index_c;
if($_index_c>=$_total_c):$hd["list"]["c"]["last"]=true;endif;?>

					<tr>
						<td>
						<input type="checkbox" name="aid[]" value="<?php echo $c['aid'];?>"/>
						</td>
						<td><?php echo $c['aid'];?></td>
						<td><?php echo $c['cid'];?></td>
						<td>
						<input type="text" class="w30" value="<?php echo $c['arc_sort'];?>" name="arc_order[<?php echo $c['aid'];?>]"/>
						</td>
						<td>
						<a href="<?php echo U('Index/Index/content',array('mid'=>$_GET['mid'],'cid'=>$_GET['cid'],'aid'=>$c['aid']));?>" target="_blank">
							<?php echo $c['title'];?>
						</a>
						<?php if($c['flag']){?>
							<span style="color:#FF0000"> [<?php echo $c['flag'];?>]</span>
						<?php }?></td>
						<td>
						<?php if($c['state'] == 1){?>
							已审核
							<?php  }else{ ?>
								未审核
						<?php }?></td>
						<td><?php echo $c['username'];?></td>
						<td><?php echo date('Y-m-d',$c['updatetime']);?></td>
						<td>
						<a href="<?php echo Url::getContentUrl($c);?>" target="_blank">
							访问
						</a><span
						class="line">|</span>
						<a href="javascript:hd_open_window('<?php echo U(edit,array('cid'=>$_GET['cid'],'mid'=>$_GET['mid'],'aid'=>$c['aid']));?>')">编辑
						</a><span class="line">|</span>
						<a href="javascript:" onclick="hd_confirm('确认删除吗？',function(){hd_ajax('<?php echo U('del');?>',{aid:<?php echo $c['aid'];?>,mid:<?php echo $c['mid'];?>})})">
							删除
						</a>
						</td>
					</tr>
				<?php $hd["list"]["c"]["first"]=false;
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
			<input type="button" class="hd-cancel" onclick="order(<?php echo $_GET['mid'];?>,<?php echo $_GET['cid'];?>)" value="更改排序"/>
			<input type="button" class="hd-cancel" onclick="del(<?php echo $_GET['mid'];?>,<?php echo $_GET['cid'];?>)" value="批量删除"/>
			<input type="button" class="hd-cancel" onclick="audit(<?php echo $_GET['mid'];?>,<?php echo $_GET['cid'];?>,1)" value="审核"/>
			<input type="button" class="hd-cancel" onclick="audit(<?php echo $_GET['mid'];?>,<?php echo $_GET['cid'];?>,0)" value="取消审核"/>
			<input type="button" class="hd-cancel" onclick="move(<?php echo $_GET['mid'];?>,<?php echo $_GET['cid'];?>)" value="批量移动"/>
		</div>
	</body>
</html>