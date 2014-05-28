<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>审核内容</title>
    <hdjs/>
    <js file="__GROUP__/static/js/js.js"/>
    <js file="__CONTROL_TPL__/js/content.js"/>
    <css file="__CONTROL_TPL__/css/css.css"/>
</head>
<body>
<div class="wrap">
    <form id="search" action="{|U:'content'}" class="hd-form" method="post">
        <div class="search">
            模型：
            <select name="mid" class="w100">
                <list from='$model' name="m">
                <option value="{$m.mid}" <if value="$mid eq $m.mid">selected=''</if>>{$m.model_name}</option>
                </list>
            </select>
        </div>
    </form>
    <script>
        $("[name='mid'").change(function(){
            $("#search").trigger('submit');
        })
    </script>
    <div class="menu_list">
        <ul>
            <li>
                <a href="{|U:'content'}" class="action">文章列表</a>
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
            <td>标题</td>
            <td class="w100">栏目</td>
            <td class="w100">作者</td>
            <td class="w80">修改时间</td>
            <td class="w50">操作</td>
        </tr>
        </thead>
        <list from="$data" name="d">
            <tr>
                <td><input type="checkbox" name="aid[]" value="{$d.aid}"/></td>
                <td>{$d.aid}</td>
                <td>
                    <a href="{|U:'Index/Index/Content',array('mid'=>$mid,'cid'=>$d['cid'],'aid'=>$d['aid'])}" target="_blank">{$d.title}</a>
                </td>
                <td>
                    {$d.catname}
                </td>
                <td>
                    <a href="__ROOT__/index.php?{$d.uid}" target="_blank">{$d.username}</a>
                    </td>
                <td>{$d.updatetime|date:"Y-m-d",@@}</td>
                <td>
                    <a href="{|U:'Index/Article/show',array('mid'=>$mid,'cid'=>$d['cid'],'aid'=>$d['aid'])}" target="_blank">
                        访问</a>
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
    <input type="button" class="hd-cancel" onclick="del()" value="批量删除"/>
    <input type="button" class="hd-cancel" onclick="audit({$mid},1)" value="审核"/>
</div>
</body>
</html>