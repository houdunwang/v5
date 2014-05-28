<?php if(!defined("HDPHP_PATH"))exit;C("SHOW_NOTICE",FALSE);?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>批量编辑栏目</title>
	<script type='text/javascript' src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend/Org/Jquery/jquery-1.8.2.min.js'></script>
<link href='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/css/hdjs.css' rel='stylesheet' media='screen'>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/js/hdjs.js'></script>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/js/slide.js'></script>
<script src='http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/../hdjs/org/cal/lhgcalendar.min.js'></script>
<script type='text/javascript'>
		HOST = 'http://localhost';
		ROOT = 'http://localhost/v5/cmsweb/hdcms';
		WEB = 'http://localhost/v5/cmsweb/hdcms/index.php';
		URL = 'http://localhost/v5/cmsweb/hdcms/a=Admin&c=Category&m=BulkEdit';
		HDPHP = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp';
		HDPHPDATA = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Data';
		HDPHPTPL = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Lib/Tpl';
		HDPHPEXTEND = 'http://localhost/v5/cmsweb/hdcms/hd/HDPHP/hdphp/Extend';
		APP = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin';
		CONTROL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=Category';
		METH = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=Category&m=BulkEdit';
		GROUP = 'http://localhost/v5/cmsweb/hdcms/hd';
		TPL = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl';
		CONTROLTPL = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/Category';
		STATIC = 'http://localhost/v5/cmsweb/hdcms/Static';
		PUBLIC = 'http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/Public';
		HISTORY = 'http://localhost/v5/cmsweb/hdcms/a=Admin&c=Category&m=index';
		HTTPREFERER = 'http://localhost/v5/cmsweb/hdcms/a=Admin&c=Category&m=index';
		TEMPLATE = 'http://localhost/v5/cmsweb/hdcms/template/default';
		ROOTURL = 'http://localhost/v5/cmsweb/hdcms';
		WEBURL = 'http://localhost/v5/cmsweb/hdcms/index.php';
		CONTROLURL = 'http://localhost/v5/cmsweb/hdcms/index.php?a=Admin&c=Category';
</script>
	<link type="text/css" rel="stylesheet" href="http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/Category/css/css.css"/>
	<script type="text/javascript" src="http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/Category/js/js.js"></script>
	<script type="text/javascript" src="http://localhost/v5/cmsweb/hdcms/hd/Hdcms/Admin/Tpl/Content/js/addEdit.js"></script>
	<style type="text/css">
		div.wrap {
		  	padding-right: 0px;
		}
		div.wrap div.category {
		  	overflow: auto;
		}
		div.wrap div.category table th,
		div.wrap div.category table td {
		  	border-right: 1px solid #dcdcdc;
		}
	</style>
</head>
<body>
	<div class="wrap">
		<div class="menu_list">
					<ul>
						<li>
							<a href="<?php echo U('Category/index');?>">
								栏目列表
							</a>
						</li>
						<li>
							<a href="javascript:;" class="action">
								批量修改栏目
							</a>
						</li>
					</ul>
		</div>
		<div class="help">
			双击单选框，可以选中所有同类型
		</div>
		<form action="<?php echo U('BulkEdit');?>" class="hd-form" method="post" onsubmit="return hd_submit(this,'<?php echo U('Category/index');?>');">
			<input type="hidden" name="BulkEdit" value="1" />
		<div class="title-header">批量编辑栏目</div>
		<div class="category">
		<table>
			<tr>
		<?php $hd["list"]["field"]["total"]=0;if(isset($data) && !empty($data)):$_id_field=0;$_index_field=0;$lastfield=min(1000,count($data));
$hd["list"]["field"]["first"]=true;
$hd["list"]["field"]["last"]=false;
$_total_field=ceil($lastfield/1);$hd["list"]["field"]["total"]=$_total_field;
$_data_field = array_slice($data,0,$lastfield);
if(count($_data_field)==0):echo "";
else:
foreach($_data_field as $key=>$field):
if(($_id_field)%1==0):$_id_field++;else:$_id_field++;continue;endif;
$hd["list"]["field"]["index"]=++$_index_field;
if($_index_field>=$_total_field):$hd["list"]["field"]["last"]=true;endif;?>

			<td class="w300">
				<table class="table1 category" style="width:100%;">
					<tr>
						<th>栏目名称</th>
					</tr>
					<tr>
						<td>
							<input type="hidden" name="cat[<?php echo $field['cid'];?>][cid]" value="<?php echo $field['cid'];?>"/>
							<input type="text" name="cat[<?php echo $field['cid'];?>][catname]" value="<?php echo $field['catname'];?>" class="w250"/>
						</td>
					</tr>
					<tr>
						<th>静态目录</th>
					</tr>
					<tr>
						<td>
							<input type="text" name="cat[<?php echo $field['cid'];?>][catdir]" value="<?php echo $field['catdir'];?>" class="w250"/>
						</td>
					</tr>
					<tr>
						<th>栏目访问</th>
					</tr>
					<tr>
						<td>
							<label>
							     <input type="radio" name="cat[<?php echo $field['cid'];?>][cat_url_type]" value="1" <?php if($field['cat_url_type']==1){?>checked="checked"<?php }?>/> 静态
                                </label>
                                <label>
                                    <input type="radio" name="cat[<?php echo $field['cid'];?>][cat_url_type]" value="2" <?php if($field['cat_url_type']==2){?>checked="checked"<?php }?>/> 动态
                                </label>
						</td>
					</tr>
					<tr>
						<th>文章访问</th>
					</tr>
					<tr>
						<td>
							 <label>
                                    <input type="radio" name="cat[<?php echo $field['cid'];?>][arc_url_type]" value="1" <?php if($field['arc_url_type']==1){?>checked="checked"<?php }?>/> 静态
                                </label>
                                <label>
                                    <input type="radio" name="cat[<?php echo $field['cid'];?>][arc_url_type]" value="2" <?php if($field['arc_url_type']==2){?>checked="checked"<?php }?>/> 动态
                                </label>
						</td>
					</tr>
					<tr>
						<th>在导航显示</th>
					</tr>
					<tr>
                            <td>
                                <label>
                                    <input type="radio" name="cat[<?php echo $field['cid'];?>][cat_show]" value="1" <?php if($field['cat_show']==1){?>checked="checked"<?php }?>/> 是
                                </label>
                                <label>
                                    <input type="radio" name="cat[<?php echo $field['cid'];?>][cat_show]" value="0" <?php if($field['cat_show']==0){?>checked="checked"<?php }?>/> 否
                                </label>
                            </td>
                  	</tr>
                  	<tr>
                  		<th class="w100">封面模板</th>
                  	</tr>
                  	 <tr>
                            <td>
                                <input type="text" name="cat[<?php echo $field['cid'];?>][index_tpl]" required="" class="w250" id="index_tpl<?php echo $field['cid'];?>" value="<?php echo $field['index_tpl'];?>"
                                       onclick="select_template('index_tpl<?php echo $field['cid'];?>')" readonly="" onfocus="select_template('index_tpl<?php echo $field['cid'];?>');"/>
                            </td>
                        </tr>
                        <tr>
                        	<th class="w100">列表页模板</th
                        </tr>
                        <tr>

                            <td>
                                <input type="text" name="cat[<?php echo $field['cid'];?>][list_tpl]" required="" id="list_tpl<?php echo $field['cid'];?>" class="w250" value="<?php echo $field['list_tpl'];?>"
                                       onclick="select_template('list_tpl<?php echo $field['cid'];?>')" readonly="" onfocus="select_template('list_tpl<?php echo $field['cid'];?>');"/>
                            </td>
                        </tr>
                        <tr>
                        	<th>内容页模板</th>
                        </tr>
                        <tr>
                            
                            <td>
                                <input type="text" name="cat[<?php echo $field['cid'];?>][arc_tpl]" required="" id="arc_tpl<?php echo $field['cid'];?>" class="w250" value="<?php echo $field['arc_tpl'];?>"
                                       onclick="select_template('arc_tpl<?php echo $field['cid'];?>')" readonly="" onfocus="select_template('arc_tpl<?php echo $field['cid'];?>');"/>
                            </td>
                        </tr>
                        <tr>
                        	<th class="w100">栏目页URL规则</th>
                        </tr>
                        <tr>
                            
                            <td>
                                <input type="text" name="cat[<?php echo $field['cid'];?>][cat_html_url]" required="" class="w250" value="<?php echo $field['cat_html_url'];?>"/>
                                <span id="hd_cat_html_url"></span>
                            </td>
                        </tr>
                        <tr>
                        	<th>内容页URL规则</th>
                        </tr>
                        <tr>
                            
                            <td>
                                <input type="text" name="cat[<?php echo $field['cid'];?>][arc_html_url]" required="" class="w250" value="<?php echo $field['arc_html_url'];?>"/>
                                <span id="hd_arc_html_url"></span>
                            </td>
                        </tr>
                        
                        
                        <tr>
                        	<th>关键字</th>
                        </tr>
                        <tr>
                            
                            <td>
                                <input type="text" name="cat[<?php echo $field['cid'];?>][cat_keyworks]" value="<?php echo $field['cat_keyworks'];?>" class="w250"/>
                            </td>
                        </tr>
                        <tr>
                        	<th>描述</th>
                        </tr>
                        <tr>
                            
                            <td>
                                <textarea name="cat[<?php echo $field['cid'];?>][cat_description]" class="w250 h100"><?php echo $field['cat_description'];?></textarea>
                            </td>
                        </tr>
                        <tr>
                        	<th class="w100">SEO标题</th>
                        </tr>
                        <tr>
                            
                            <td>
                                <input type="text" name="cat[<?php echo $field['cid'];?>][cat_seo_title]" value="<?php echo $field['cat_seo_title'];?>" class="w250"/>
                            </td>
                        </tr>
                        <tr>
                        	<th>SEO描述</th>
                        </tr>
                        <tr>
                            <td>
                                <textarea name="cat[<?php echo $field['cid'];?>][cat_seo_description]" class="w250 h150"><?php echo $field['cat_seo_description'];?></textarea>
                            </td>
                        </tr>
				</table>
			</td>
		<?php $hd["list"]["field"]["first"]=false;
endforeach;
endif;
else:
echo "";
endif;?>
			</tr>
		</table>
		</div>
		<div class="position-bottom">
			<input type="submit" class="hd-success" value="确定"/>
		</div>
		</form>
	</div>
	<script type="text/javascript" charset="utf-8">
		$(function(){
			alert_div();
		})
		function alert_div(){
			var _h = $(window).height()-180;
			$("div.category").css({height:_h+'px'});
		}
		$(window).resize(function(){
			alert_div();
		})
		
		$(function(){
			$('input[type=radio]').dblclick(function(e){
				var tr_index =$($(this).parents('tr')).index();
				var label_index =$($(this).parent()).index();
				$("table.category").each(function(){
					$(this).find('tr').eq(tr_index).find('label').eq(label_index).find('input').attr('checked','checked');
				})
			})
			$('label').dblclick(function(e){
				var tr_index =$($(this).parents('tr')).index();
				var label_index =$(this).index();
				$("table.category").each(function(){
					$(this).find('tr').eq(tr_index).find('label').eq(label_index).find('input').attr('checked','checked');
				})
			})
		})
	</script>
</body>
</html>
