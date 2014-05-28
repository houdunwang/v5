<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
		<title>内容列表</title>
		<hdjs/>
		<js file="__CONTROL_TPL__/js/content.js"/>
		<css file="__CONTROL_TPL__/css/css.css"/>
	</head>
	<body>
		<div class="wrap">
			<form action="{|U:'content',array('mid'=>$_GET['mid'],'cid'=>$_GET['cid'])}" class="hd-form" method="post">
				<input type="hidden" name="m" value="content"/>
				<input type="hidden" name="mid" value="{$hd.get.mid}"/>
				<input type="hidden" name="cid" value="{$hd.get.cid}"/>
				<input type="hidden" name="state" value="{$hd.get.state}"/>
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
						<list from="$flag" name="f">
							<option value="{$f}" <if value="$hd.post.flag eq $f">selected=''</if>>{$f}</option>
						</list>
					</select>
					&nbsp;&nbsp;&nbsp;
					<select name="search_type" class="w100">
						<option value="1" <if value="$hd.get.search_type eq 1">selected=''</if>>标题</option>
						<option value="2" <if value="$hd.get.search_type eq 2">selected=''</if>>简介</option>
						<option value="3" <if value="$hd.get.search_type eq 3">selected=''</if>>用户名</option>
						<option value="4" <if value="$hd.get.search_type eq 4">selected=''</if>>用户uid</option>
					</select>&nbsp;&nbsp;&nbsp;
					关键字：
					<input class="w200" type="text" placeholder="请输入关键字..." value="{$hd.post.search_keyword}" name="search_keyword">
					<button class="hd-cancel" type="submit">
						搜索
					</button>
				</div>
			</form>
			<div class="menu_list">
				<ul>
					<li>
						<a href="{|U:'content',array('mid'=>$_GET['mid'],'cid'=>$_GET['cid'],'content_state'=>1)}"
						<if value="$hd.get.content_state==1">class="action"</if> >
							内容列表
						</a>
					</li>
					<li>
						<a href="{|U:'content',array('mid'=>$_GET['mid'],'cid'=>$_GET['cid'],'content_state'=>0)}"
						<if value="$hd.get.content_state==0">class="action"</if> >
							未审核
						</a>
					</li>
					<li>
						<a href="javascript:;" onclick="hd_open_window('{|U:add,array('cid'=>$_GET['cid'],'mid'=>$_GET['mid'])}')">
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
				<list from="$data" name="c">
					<tr>
						<td>
						<input type="checkbox" name="aid[]" value="{$c.aid}"/>
						</td>
						<td>{$c.aid}</td>
						<td>{$c.cid}</td>
						<td>
						<input type="text" class="w30" value="{$c.arc_sort}" name="arc_order[{$c.aid}]"/>
						</td>
						<td>
						<a href="{|U:'Index/Index/content',array('mid'=>$_GET['mid'],'cid'=>$_GET['cid'],'aid'=>$c['aid'])}" target="_blank">
							{$c.title}
						</a>
						<if value="$c.flag">
							<span style="color:#FF0000"> [{$c.flag}]</span>
						</if></td>
						<td>
						<if value="$c.content_state eq 1">
							已审核
							<else>
								未审核
						</if></td>
						<td>{$c.username}</td>
						<td>{$c.updatetime|date:"Y-m-d",@@}</td>
						<td>
						<a href="<?php echo Url::getContentUrl($c);?>" target="_blank">
							访问
						</a><span
						class="line">|</span>
						<a href="javascript:hd_open_window('{|U:edit,array('cid'=>$_GET['cid'],'mid'=>$_GET['mid'],'aid'=>$c['aid'])}')">编辑
						</a><span class="line">|</span>
						<a href="javascript:" onclick="hd_confirm('确认删除吗？',function(){hd_ajax('{|U:'del'}',{aid:{$c['aid']},cid:{$c['cid']},mid:{$c['mid']}})})">
							删除
						</a>
						</td>
					</tr>
				</list>
			</table>
			<div class="page1">
				{$page}
			</div>
		</div>

		<div class="position-bottom">
			<input type="button" class="hd-cancel" value="全选" onclick="select_all('.table2')"/>
			<input type="button" class="hd-cancel" value="反选" onclick="reverse_select('.table2')"/>
			<input type="button" class="hd-cancel" onclick="order({$hd.get.mid},{$hd.get.cid})" value="更改排序"/>
			<input type="button" class="hd-cancel" onclick="del({$hd.get.mid},{$hd.get.cid})" value="批量删除"/>
			<input type="button" class="hd-cancel" onclick="audit({$hd.get.mid},{$hd.get.cid},1)" value="审核"/>
			<input type="button" class="hd-cancel" onclick="audit({$hd.get.mid},{$hd.get.cid},0)" value="取消审核"/>
			<input type="button" class="hd-cancel" onclick="move({$hd.get.mid},{$hd.get.cid})" value="批量移动"/>
		</div>
	</body>
</html>