<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>批量移动文章</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/move.js"/>
    <css file="__CONTROL_TPL__/css/move.css"/>
</head>
<body>
<div class="wrap">
    <div class="title-header">温馨提示</div>
    <div class="help" style="margin-bottom:0px;"> 不能够跨模型移动文章</div>
    <div class="line"></div>
    <form action="__METH__" method="post" onsubmit="return false" class="hd-form">
    	<input type="hidden" name="mid" value="{$hd.get.mid}"/>
        <input type="hidden" name="cid" value="{$hd.get.cid}"/>
        <table style="table1">
            <tr>
                <td>
                    指定来源
                </td>
                <td>
                    目标栏目
                </td>
            </tr>
            <tr>
                <td>
                    <ul class="fromtype">
                        <li>
                            <label><input type="radio" name="from_type" value="1" checked="checked"/> 从指定aid </label>
                        </li>
                        <li>
                            <label> <input type="radio" name="from_type" value="2" /> 从指定栏目</label>
                        </li>
                    </ul>
                    <div id="t_aid">
                        <textarea name="aid" class="w250 h250">{$hd.get.aid}</textarea>
                    </div>
                    <div id="f_cat" style="display: none">
                        <select id="fromid" style="width:250px;height:250px;" multiple="multiple" size="2"
                                name="from_cid[]">
                            <list from="$category" name="c">
                                <option value="{$c.cid}" {$c.disabled}>
                                {$c._name}
                                </option>
                            </list>
                        </select>
                    </div>
                </td>
                <td>
                    <select id="fromid" style="width:250px;height:290px;"  size="100"
                            name="to_cid">
                        <list from="$category" name="c">
                            <option value="{$c.cid}" {$c.disabled} {$c.selected}>
                            {$c._name}
                            </option>
                        </list>
                    </select>
                </td>
            </tr>
        </table>
        <div class="position-bottom">
            <input type="submit" class="hd-success" value="确定"/>
            <input type="button" class="hd-cancel" id="close_window" value="关闭"/>
        </div>
    </form>
</div>
</body>
</html>