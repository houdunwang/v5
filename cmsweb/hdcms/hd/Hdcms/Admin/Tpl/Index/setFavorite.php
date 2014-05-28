<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
		<title>设置常用菜单</title>
		<hdjs/>
		<style type="text/css">
			ul li {
				width: 130px;
				float: left;
			}

		</style>
	</head>
	<body>
		<form method="post" class="hd-form" action="__METH__" onsubmit="return hd_submit(this,'',function(){top.location.href=top.location.href});">
			<div class="wrap">
				<div class="title-header">
					设置常用菜单
				</div>
				<table class="table1">
					<list from="$data" name="n">
						<list from="$n._data" name="d">
							<tr>
								<th class="w200">
								<div class="level2">
									{$d.title}
								</div></th>
								<td>
								<ul>
									<list from="$d._data" name="m">
										<li>
											<label><input type="checkbox" name="nid[]" value="{$m.nid}" <if value="!empty($m['uid'])">checked=""</if>/> {$m.title}</label>
										</li>
									</list>
								</ul></td>
							</tr>
						</list>
					</list>
				</table>
			</div>
			<div class="position-bottom">
				<input type='submit' class="hd-success" value="确定"/>
			</div>
		</form>
	</body>
</html>