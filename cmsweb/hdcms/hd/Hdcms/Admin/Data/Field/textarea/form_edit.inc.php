<script type="text/javascript" src="<?php echo __ROOT__;?>/hd/Hdcms/Admin/Data/Field/textarea/validate.js"></script>
<table class="table1">
    <tr class="input action">
        <th class="w400">参数</th>
        <td>
            <table class="table1">
                <tr>
                    <td class="w100">宽度</td>
                    <td><input type="text" name="set[width]" class="w100 textarea_width" value="<?php echo $field['set']['width'];?>"/> </td>
                </tr>
                <tr>
                    <td>高度</td>
                    <td><input type="text" name="set[height]" class="w100 textarea_height" value="<?php echo $field['set']['height'];?>"/> </td>
                </tr>
                <tr>
                    <td>默认值</td>
                    <td><textarea class="w300 h60" name="set[default]"><?php echo $field['set']['default'];?></textarea></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
