<script type="text/javascript" src="<?php echo __ROOT__;?>/hd/Hdcms/Admin/Data/Field/<?php echo $field_type;?>/validate.js"></script>
<table class="table1">
    <tr class="input action">
        <th class="w400">参数</th>
        <td>
            <table class="table1">
                <tr>
                    <td class="w100">选项列表</td>
                    <td>
                        <textarea name="set[options]" class="w300 h100 select_options">选项值1|选项名称1</textarea>
                    </td>
                </tr>
                <tr>
                    <td class="w100">选项类型</td>
                    <td>
                        <label><input type="radio" name="set[form_type]" value="radio" checked="checked"/> 单选按钮</label>
                        <label><input type="radio" name="set[form_type]" value="checkbox"/> 复选框</label>
                        <label><input type="radio" name="set[form_type]" value="select"/> 下拉框</label>
                    </td>
                </tr>
                <tr>
                    <td>默认值</td>
                    <td><input type="text" name="set[default]" class="w100 select_default"/></td>
                </tr>
            </table>
        </td>
    </tr>
</table>