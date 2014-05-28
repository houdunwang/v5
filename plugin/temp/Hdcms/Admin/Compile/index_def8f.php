<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
		<title>模型管理</title>
		<script type='text/javascript' src='http://localhost/v5/plugin/hd/HDPHP/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/plugin/hd/HDPHP/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/plugin';
		WEB = 'http://localhost/v5/plugin/index.php';
		URL = 'http://localhost/v5/plugin/index.php?a=Admin&c=Model&m=index';
		HDPHP = 'http://localhost/v5/plugin/hd/HDPHP/hdphp';
		HDPHPDATA = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/plugin/hd/HDPHP/hdphp/Extend';
		APP = 'http://localhost/v5/plugin/index.php?a=Admin';
		CONTROL = 'http://localhost/v5/plugin/index.php?a=Admin&c=Model';
		METH = 'http://localhost/v5/plugin/index.php?a=Admin&c=Model&m=index';
		GROUP = 'http://localhost/v5/plugin/hd';
		TPL = 'http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl';
		CONTROLTPL = 'http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Model';
		STATIC = 'http://localhost/v5/plugin/Static';
		PUBLIC = 'http://localhost/v5/plugin/hd/Hdcms/Admin/Tpl/Public';
		HISTORY = 'http://localhost/v5/plugin/index.php?a=Admin&c=Field&m=index&mid=2';
		HTTPREFERER = 'http://localhost/v5/plugin/index.php?a=Admin&c=Field&m=index&mid=2';
</script>
	</head>
	<body>
		<div class="wrap">
			<div class="menu_list">
				<ul>
					<li>
						<a href="javascript:;" class="action">
							模型列表
						</a>
					</li>
					<li>
						<a href="<?php echo U('add');?>">
							添加模型
						</a>
					</li>
					<li>
						<a href="javascript:;" onclick="hd_ajax('<?php echo U(updateCache);?>')">
							更新缓存
						</a>
					</li>
				</ul>
			</div>
			<div class="content">
				<table class="table2 table-title">
					<thead>
						<tr>
							<td class="w30">mid</td>
							<td>模型名称</td>
							<td class="w100">系统</td>
							<td class="w100">主表</td>
							<td class="w100">副表</td>
							<td class="w30">状态</td>
							<td class="w150">操作</td>
						</tr>
					</thead>
					<tbody>
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

							<tr>
								<td><?php echo $m['mid'];?></td>
								<td><?php echo $m['model_name'];?></td>
								<td>
								<?php if($m['is_system'] == 1){?>
									<font color="red">√</font>
									<?php  }else{ ?>
									<font color="blue">×</font>
								<?php }?></td>
								<td><?php echo $m['table_name'];?></td>
								<td>
								<?php if($m['type']==1){?>
									<?php echo $m['table_name'];?>_data
									<?php  }else{ ?>
										无
								<?php }?></td>
								<td>
								<?php if($m['enable']){?>
									开启
									<?php  }else{ ?>
										关闭
								<?php }?></td>
								<td>
								<a href="<?php echo U('Field/index',array('mid'=>$m['mid']));?>">
									字段管理
								</a> |
								<?php if($m['is_system']==1){?>
									修改
									<?php  }else{ ?>
										<a href="<?php echo U('edit',array('mid'=>$m['mid']));?>">
											修改
										</a>
								<?php }?> |
								<?php if($m['is_system']==1||in_array($m['table_name'],$forbidDelete)){?>
									删除
									<?php  }else{ ?>
										<a href="javascript:hd_confirm('确证删除吗？',function(){hd_ajax('<?php echo U('del');?>', {mid: <?php echo $m['mid'];?>})})">
											删除
										</a>
								<?php }?></td>
							</tr>
						<?php $hd["list"]["m"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>