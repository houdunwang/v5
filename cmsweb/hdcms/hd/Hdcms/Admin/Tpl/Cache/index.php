<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
		<title>生成首页</title>
		<hdjs/>
	</head>
	<body>
		<form method="post" action="{|U:'index'}" class="hd-form">
			<div class="wrap">
				<div class="title-header">
					温馨提示
				</div>
				<div class="help">
					首次安装必须更新全站缓存
				</div>
				<div class="title-header">
					更新缓存
				</div>
				<style type="text/css">
					table.table2 td{
						height:35px;
					}
				</style>
				<table class="table1">
					<tr>
						<th class="w100">选择更新</th>
						<td>
						<table class="table2">
							<tr>
								<td><label>
									<input type="checkbox" name="Action[]" value="Config" checked=''/>
									更新网站配置 </label></td>
							</tr>
							<tr>
								<td><label>
									<input type="checkbox" name="Action[]" value="Model" checked=''/>
									内容模型 </label></td>
							</tr>
							<tr>
								<td><label>
									<input type="checkbox" name="Action[]" value="Field" checked=''/>
									模型字段 </label></td>
							</tr>
							<tr>
								<td><label>
									<input type="checkbox" name="Action[]" value="Category" checked=''/>
									栏目缓存 </label></td>
							</tr>
							<tr>
								<td><label>
									<input type="checkbox" name="Action[]" value="Table" checked=''/>
									数据表缓存 </label></td>
							</tr>
							<tr>
								<td><label>
									<input type="checkbox" name="Action[]" value="Node" checked=''/>
									权限节点 </label></td>
							</tr>
							<tr>
								<td><label>
									<input type="checkbox" name="Action[]" value="Role" checked=''/>
									会员角色 </label></td>
							</tr>
							<tr>
								<td><label>
									<input type="checkbox" name="Action[]" value="Flag" checked=''/>
									内容FLAG </label></td>
							</tr>
						</table></td>
					</tr>
				</table>
				<div class="position-bottom">
					<input type="submit" value="开始更新" class="hd-success"/>
				</div>
			</div>
		</form>
	</body>
</html>