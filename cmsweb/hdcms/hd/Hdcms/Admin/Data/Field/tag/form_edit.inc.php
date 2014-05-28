<script type="text/javascript" src="<?php echo __ROOT__;?>/hd/Hdcms/Admin/Data/Field/tag/validate.js"></script>
<table class="table1">
    <tr class="input action">
        <th class="w400">参数</th>
        <td>
            <table class="table1">
                <tr>
                    <td class="w100">显示长度</td>
                    <td><input type="text" name="set[size]" class="w100 input_size" value="<?php echo $field['set']['size'];?>"/> px</td>
                </tr>
                <tr>
                    <td>默认值</td>
                    <td><input type="text" name="set[default]" class="w200" value="<?php echo $field['set']['default'];?>"/></td>
                </tr>
                <tr>
                    <td>是否为密码</td>
                    <td>
                        <label><input type="radio" name="set[ispasswd]" value="1" <?php if($field['set']['ispasswd'] == 1){?>checked=""<?php }?>/> 是</label>
                        <label><input type="radio" name="set[ispasswd]" value="0" <?php if($field['set']['ispasswd'] == 0){?>checked=""<?php }?>/> 否</label>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>