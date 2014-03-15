<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><html>
<head>
	<title>栏目列表</title>
	<meta charset='utf-8'/>
	<script type='text/javascript' src='http://localhost/v5/cms/hdphp/hdphp/../hdjs/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/cms/hdphp/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/cms/hdphp/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/cms/hdphp/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/cms/hdphp/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/cms';
		WEB = 'http://localhost/v5/cms/index.php';
		URL = 'http://localhost/v5/cms/index.php/Article/Article/index';
		HDPHP = 'http://localhost/v5/cms/hdphp/hdphp';
		HDPHPDATA = 'http://localhost/v5/cms/hdphp/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/cms/hdphp/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/cms/hdphp/hdphp/Extend';
		APP = 'http://localhost/v5/cms/index.php/Article';
		CONTROL = 'http://localhost/v5/cms/index.php/Article/Article';
		METH = 'http://localhost/v5/cms/index.php/Article/Article/index';
		GROUP = 'http://localhost/v5/cms/Cms';
		TPL = 'http://localhost/v5/cms/Cms/App/Article/Tpl';
		CONTROLTPL = 'http://localhost/v5/cms/Cms/App/Article/Tpl/Article';
		STATIC = 'http://localhost/v5/cms/Static';
		PUBLIC = 'http://localhost/v5/cms/Cms/App/Article/Tpl/Public';
		HISTORY = 'http://localhost/v5/cms/index.php/Admin/Index/index';
		HTTPREFERER = 'http://localhost/v5/cms/index.php/Admin/Index/index';
</script>
</head>
<body>
<div class="menu_list">
	<ul>
		 <li><a href="<?php echo U('index');?>"  class="action"> 文章列表 </a></li>
		 <li><a href="<?php echo U('add');?>"> 添加文章 </a></li>
	</ul>
</div>
<div>
	<table class='table2'>
		<thead>
			<tr>
				<td class='w50'>ID</td>
				<td>标题</td>
				<td class='w100'>作者</td>
				<td class='w100'>点击数</td>
				<td class='w150'>操作</td>
			</tr>
		</thead>
		<?php $hd["list"]["a"]["total"]=0;if(isset($article) && !empty($article)):$_id_a=0;$_index_a=0;$lasta=min(1000,count($article));
$hd["list"]["a"]["first"]=true;
$hd["list"]["a"]["last"]=false;
$_total_a=ceil($lasta/1);$hd["list"]["a"]["total"]=$_total_a;
$_data_a = array_slice($article,0,$lasta);
if(count($_data_a)==0):echo "";
else:
foreach($_data_a as $key=>$a):
if(($_id_a)%1==0):$_id_a++;else:$_id_a++;continue;endif;
$hd["list"]["a"]["index"]=++$_index_a;
if($_index_a>=$_total_a):$hd["list"]["a"]["last"]=true;endif;?>

			<tr>
				<td><?php echo $a['id'];?></td>
				<td><?php echo $a['title'];?></td>
				<td><?php echo $a['author'];?></td>
				<td><?php echo $a['click'];?></td>
				<td>
					<a href="#">查看</a> |
					<a href="<?php echo U(edit,array('id'=>$a['id']));?>">编辑</a> |
					<a href="#">删除</a>
				</td>
			</tr>
		<?php $hd["list"]["a"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
	</table>
	<div class='page1'>
		<?php echo $page;?>
	</div>
</div>
</body>
</html>