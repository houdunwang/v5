<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>批量编辑栏目</title>
	<hdjs/>
	<css file="__CONTROL_TPL__/css/css.css"/>
	<js file="__CONTROL_TPL__/js/js.js"/>
	<js file="__TPL__/Content/js/addEdit.js"/>
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
							<a href="{|U:'Category/index'}">
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
		<form action="{|U:'BulkEdit'}" class="hd-form" method="post" onsubmit="return hd_submit(this,'{|U:'Category/index'}');">
			<input type="hidden" name="BulkEdit" value="1" />
		<div class="title-header">批量编辑栏目</div>
		<div class="category">
		<table>
			<tr>
		<list from="$data" name='field'>
			<td class="w300">
				<table class="table1 category" style="width:100%;">
					<tr>
						<th>栏目名称</th>
					</tr>
					<tr>
						<td>
							<input type="hidden" name="cat[{$field.cid}][cid]" value="{$field.cid}"/>
							<input type="text" name="cat[{$field.cid}][catname]" value="{$field.catname}" class="w250"/>
						</td>
					</tr>
					<tr>
						<th>静态目录</th>
					</tr>
					<tr>
						<td>
							<input type="text" name="cat[{$field.cid}][catdir]" value="{$field.catdir}" class="w250"/>
						</td>
					</tr>
					<tr>
						<th>栏目访问</th>
					</tr>
					<tr>
						<td>
							<label>
							     <input type="radio" name="cat[{$field.cid}][cat_url_type]" value="1" <if value="$field.cat_url_type==1">checked="checked"</if>/> 静态
                                </label>
                                <label>
                                    <input type="radio" name="cat[{$field.cid}][cat_url_type]" value="2" <if value="$field.cat_url_type==2">checked="checked"</if>/> 动态
                                </label>
						</td>
					</tr>
					<tr>
						<th>文章访问</th>
					</tr>
					<tr>
						<td>
							 <label>
                                    <input type="radio" name="cat[{$field.cid}][arc_url_type]" value="1" <if value="$field.arc_url_type==1">checked="checked"</if>/> 静态
                                </label>
                                <label>
                                    <input type="radio" name="cat[{$field.cid}][arc_url_type]" value="2" <if value="$field.arc_url_type==2">checked="checked"</if>/> 动态
                                </label>
						</td>
					</tr>
					<tr>
						<th>在导航显示</th>
					</tr>
					<tr>
                            <td>
                                <label>
                                    <input type="radio" name="cat[{$field.cid}][cat_show]" value="1" <if value="$field.cat_show==1">checked="checked"</if>/> 是
                                </label>
                                <label>
                                    <input type="radio" name="cat[{$field.cid}][cat_show]" value="0" <if value="$field.cat_show==0">checked="checked"</if>/> 否
                                </label>
                            </td>
                  	</tr>
                  	<tr>
                  		<th class="w100">封面模板</th>
                  	</tr>
                  	 <tr>
                            <td>
                                <input type="text" name="cat[{$field.cid}][index_tpl]" required="" class="w250" id="index_tpl{$field.cid}" value="{$field.index_tpl}"
                                       onclick="select_template('index_tpl{$field.cid}')" readonly="" onfocus="select_template('index_tpl{$field.cid}');"/>
                            </td>
                        </tr>
                        <tr>
                        	<th class="w100">列表页模板</th
                        </tr>
                        <tr>

                            <td>
                                <input type="text" name="cat[{$field.cid}][list_tpl]" required="" id="list_tpl{$field.cid}" class="w250" value="{$field.list_tpl}"
                                       onclick="select_template('list_tpl{$field.cid}')" readonly="" onfocus="select_template('list_tpl{$field.cid}');"/>
                            </td>
                        </tr>
                        <tr>
                        	<th>内容页模板</th>
                        </tr>
                        <tr>
                            
                            <td>
                                <input type="text" name="cat[{$field.cid}][arc_tpl]" required="" id="arc_tpl{$field.cid}" class="w250" value="{$field.arc_tpl}"
                                       onclick="select_template('arc_tpl{$field.cid}')" readonly="" onfocus="select_template('arc_tpl{$field.cid}');"/>
                            </td>
                        </tr>
                        <tr>
                        	<th class="w100">栏目页URL规则</th>
                        </tr>
                        <tr>
                            
                            <td>
                                <input type="text" name="cat[{$field.cid}][cat_html_url]" required="" class="w250" value="{$field.cat_html_url}"/>
                                <span id="hd_cat_html_url"></span>
                            </td>
                        </tr>
                        <tr>
                        	<th>内容页URL规则</th>
                        </tr>
                        <tr>
                            
                            <td>
                                <input type="text" name="cat[{$field.cid}][arc_html_url]" required="" class="w250" value="{$field.arc_html_url}"/>
                                <span id="hd_arc_html_url"></span>
                            </td>
                        </tr>
                        
                        
                        <tr>
                        	<th>关键字</th>
                        </tr>
                        <tr>
                            
                            <td>
                                <input type="text" name="cat[{$field.cid}][cat_keyworks]" value="{$field.cat_keyworks}" class="w250"/>
                            </td>
                        </tr>
                        <tr>
                        	<th>描述</th>
                        </tr>
                        <tr>
                            
                            <td>
                                <textarea name="cat[{$field.cid}][cat_description]" class="w250 h100">{$field.cat_description}</textarea>
                            </td>
                        </tr>
                        <tr>
                        	<th class="w100">SEO标题</th>
                        </tr>
                        <tr>
                            
                            <td>
                                <input type="text" name="cat[{$field.cid}][cat_seo_title]" value="{$field.cat_seo_title}" class="w250"/>
                            </td>
                        </tr>
                        <tr>
                        	<th>SEO描述</th>
                        </tr>
                        <tr>
                            <td>
                                <textarea name="cat[{$field.cid}][cat_seo_description]" class="w250 h150">{$field.cat_seo_description}</textarea>
                            </td>
                        </tr>
				</table>
			</td>
		</list>
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
