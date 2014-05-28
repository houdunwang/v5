<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>备份数据库</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/backup.js"/>
</head>
<body>
<div class="wrap">
    <div class="menu_list">
        <ul>
            <li><a href="{|U:'Backup/index'}">备份列表</a></li>
            <li><a href="javascript:;" class="action">备份数据</a></li>
        </ul>
    </div>
    <form action="{|U:'backup_db'}" method="post"  class="hd-form" onsubmit="return backup();">
        <table class="table2">
            <thead>
            <tr>
                <td width="50">数据备份</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td width="50">
                    <table class="table">
                        <tr>
                            <td class="w100">分卷大小</td>
                            <td>
                                <input type="text" class="w150" name="size" value="200"/> KB
                            </td>
                        </tr>
                        <tr>
                            <td class="w100"></td>
                            <td>
                                <label>
                                    <input type="checkbox" name="structure" value="1" checked="checked">
                                    备份表结构
                                </label>
                            </td>
                        </tr>
                        <tr>
                            <td class="w100">&nbsp;</td>
                            <td>
                                <input type="submit" class="hd-cancel" value="开始备份"/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
        <table class="table2">
            <thead>
            <tr>
                <td width="50">
                    <label><input type="checkbox" class="s_all_ck"/> 全选</label>
                </td>
                <td>表名</td>
                <td>类型</td>
                <td>编码</td>
                <td>记录数</td>
                <td>使用空间</td>
                <td>碎片</td>
                <td width="200">操作</td>
            </tr>
            </thead>
            <tbody>
            <list from="$table.table" name="t">
                <tr>
                    <td>
                        <input type="checkbox" name="table[]" value="{$t.tablename}"/>
                    </td>
                    <td>{$t.tablename}</td>
                    <td>{$t.engine}</td>
                    <td>{$t.charset}</td>
                    <td>{$t.rows}</td>
                    <td>{$t.size}</td>
                    <td>{$t.data_free|default:0}</td>
                    <td>
                        <a href="javascript:hd_ajax('{|U:optimize}',{table:['{$t.tablename}']})">优化</a> |
                        <a href="javascript:hd_ajax('{|U:repair}',{table:['{$t.tablename}']})">修复</a>
                    </td>
                </tr>
            </list>
            </tbody>
        </table>
    </form>
</div>
<div class="position-bottom">
    <input type="button" class="hd-cancel" onclick="select_all('.table2')" value="全选"/>
    <input type="button" class="hd-cancel" onclick="reverse_select('.table2')" value="反选"/>
    <input type="button" class="hd-cancel" onclick="optimize()" value="批量优化"/>
    <input type="button" class="hd-cancel" onclick="repair()" value="批量修复"/>
</div>
</body>
</html>