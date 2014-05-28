<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>卸载插件</title>
    <hdjs/>
    <js file="__ROOT__/hd/Hdcms/Admin/Tpl/Index/js/menu.js"/>
    <js file="__CONTROL_TPL__/js/js.js"/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li>
                <a href="__CONTROL__&m=plugin_list">插件列表</a>
            </li>
            <li>
                <a class="action" href="javascript:;">安装插件</a>
            </li>
        </ul>
    </div>
    <div class="title-header">安装插件</div>
    <form method="post" onsubmit="return false">
        <input type="hidden" name="plugin" value="{$field.plugin}"/>
        <table class="table1 hd-form">
            <tr>
                <th class="w150">插件名称</th>
                <td>{$field.name}</td>
            </tr>
            <tr>
                <th>插件版本</th>
                <td>{$field.version}</td>
            </tr>
            <tr>
                <th>团队名称</th>
                <td>{$field.team}</td>
            </tr>
            <tr>
                <th>发布时间</th>
                <td>{$field.pubdate}</td>
            </tr>
            <tr>
                <th>网站</th>
                <td>{$field.web}</td>
            </tr>
            <tr>
                <th>电子邮箱</th>
                <td>{$field.email}</td>
            </tr>
            <tr>
                <th>对于模块的文件处理方法</th>
                <td>
                    <label>
                        <input type="radio" name="del_dir" value="0" checked="checked"/> 手工删除文件，仅运行卸载程序
                    </label>
                    <label>
                        <input type="radio" name="del_dir" value="1"/> 删除模块的所有文件
                    </label>
                </td>
            </tr>
        </table>
        <div class="position-bottom">
            <input type="submit" value="删除" class="hd-success"/>
        </div>
    </form>
</div>
</body>
</html>