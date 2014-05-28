<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>插件列表</title>
    <hdjs/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li>
                <a class="action" href="__WEB__?a=Plugin&c=Plugin&m=plugin_list">插件列表</a>
            </li>
        </ul>
    </div>
    <table class="table2 hd-form">
        <thead>
        <tr>
            <td>插件名称</td>
            <td class="w150">版本号</td>
            <td class="w150">发布时间</td>
            <td class="w150">开发团队</td>
            <td class="w150">插件状态</td>
            <td class="w100">插件目录</td>
            <td class="w50">管理</td>
        </tr>
        </thead>
        <tbody>
        <list from="$plugin" name="p">
            <tr>
                <td>{$p.name}</td>
                <td>{$p.version}</td>
                <td>{$p.pubdate}</td>
                <td>{$p.team}</td>
                <td>
                	<if value="$p.installed eq 1">
                		<font color='green'>已安装</font>
						<a href='__CONTROL__&m=uninstall&plugin={$p.dirname}' style='color:green'>
						<u>卸载</u>
						</a>
                		<else/>
                		未安装
 					<a href='__CONTROL__&m=install&plugin={$p.dirname}'><u>安装</u></a>
                	</if>
                </td>
                <td>{$p.app}</td>
                <td>
                    <a href="{|U:'Install/help',array('plugin'=>$p['app'])}">使用说明</a>
                </td>
            </tr>
        </list>
        </tbody>
    </table>
</div>
</body>
</html>