<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>生成内容页静态</title>
    <hdjs/>
    <script>
        //栏目缓存数据
        var category = {$category};
    </script>
    <js file="__CONTROL_TPL__/js/js.js"/>
    <css file="__CONTROL_TPL__/css/css.css"/>

</head>
<body>
<form method="post" action="__METH__" class="hd-form">
    <div class="wrap">
        <div class="title-header">温馨提示</div>
        <div class="help">
        	如果生成失败，请将每轮更新条数设置小些
        </div>
        <div class="title-header">规则设置</div>
        <table class="table2">
            <tr>
                <td class="w200">按照模型更新</td>
                <td class="w300">选择栏目范围</td>
                <td>选择操作内容</td>
            </tr>
            <tr>
                <td class="w200" rowspan="5">
                    <select name="mid" id="mid" style="height: 200px;width: 99%" size="2">
                        <option value="0" selected="selected">不限模型</option>
                        <list from="$model" name="m">
                            <option value="{$m.mid}">{$m.model_name}</option>
                        </list>
                    </select>
                </td>
                <td class="w300" rowspan="5">
                    <select name="cid[]" id="cid" style="height: 200px;width: 99%"
                            title="按住“Ctrl”或“Shift”键可以多选，按住“Ctrl”可取消选择" multiple="multiple">
                        <option value="0" selected="selected">不限栏目</option>
                        <list from="$category" name="c" multiple="multiple">
                            <option value="{$c.cid}"
                            {$c.opt}>{$c.catname}</option>
                        </list>
                    </select>
                </td>
                <td>
                    <font color="red">
                        每轮更新
                        <input class="w100" type="text" value="20" id="row" name="step_row">
                        条信息
                    </font></td>
                </td>
            </tr>
            <tr>
                <td> 更新所有信息 <input type="button" value="开始更新" class="hd-cancel-small" onclick="form_submit('all')"/>
                </td>
            </tr>
            <tr style="display: none;">
                <td>
                    更新最新发布的 <input class="input" type="text" size="4" value="100" name="total_row"> 条信息
                    <input type="button" value="开始更新" class="hd-cancel-small" onclick="form_submit('new')"/>
                </td>
            </tr>
            <tr style="display: none;">
                <td>更新发布时间从
                    <input class="w80" type="text" id="start_time" name="start_time"> 到
                    <input class="w80" type="text" id="end_time" name="end_time"> 的信息
                    <input type="button" value="开始更新" class="hd-cancel-small" onclick="form_submit('time')"/>
                    <script>
                        $('#start_time').calendar({format: 'yyyy/MM/dd'});
                        $('#end_time').calendar({format: 'yyyy/MM/dd'});
                    </script>
                </td>
            </tr>
            <tr style="display: none;">
                <td>
                    更新ID从 <input class="input" type="text" size="4" name="start_id"> 到
                    <input class="input" type="text" size="4" name="end_id"> 的信息
                    <input type="button" value="开始更新" class="hd-cancel-small" onclick="form_submit('id')"/>
                </td>
            </tr>
        </table>
    </div>
</form>
</body>
</html>