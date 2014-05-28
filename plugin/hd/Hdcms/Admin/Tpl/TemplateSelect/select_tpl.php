<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>选择模板</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/select_tpl.js"/>
</head>
<body>
<div id="select_tpl" style="overflow-y: auto;height:315px;">
    <if value="$hd.get.path">
        <a href="javascript:window.history.back();" class="back hd-cancel" style="padding:2px 10px;margin:5px;">返回</a>
    </if>
    <table class="table2">
        <thead>
        <tr>
            <td>名称</td>
            <td class="w150">大小</td>
            <td class="w80">修改时间</td>
        </tr>
        </thead>
        <list from="$file" name="f">
            <tr>
                <td>
                    <div>
                        <a href="javascript:;" class="{$f.type}" name="{$hd.get.name}" path="{$f.path}">
                            <span class="{$f.type}">{$f.name}</span>
                        </a>
                    </div>
                </td>
                <td>{$f.size|get_size}</td>
                <td>{$f.filemtime|date:"Y-m-d",@@}</td>
            </tr>
        </list>
    </table>
</div>
</body>
</html>