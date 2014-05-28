<script type="text/javascript" src="<?php echo __ROOT__;?>/hd/Hdcms/Admin/Data/Field/editor/validate.js"></script>
<table class="table1">
    <tr class="input action">
        <th class="w400">参数</th>
        <td>
            <table class="table1">
                <tr>
                    <td class="w60">高度</td>
                    <td><input type="text" name="set[height]" class="w100 editor_height" value="<?php echo $field['set']['height'];?>" class="w100"/> px</td>
                </tr>
                <tr>
                    <td>默认值</td>
                    <td><textarea class="w300 h60" name="set[default]"><?php echo $field['set']['default'];?></textarea></td>
                </tr>
            </table>
        </td>
    </tr>
</table>