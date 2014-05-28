<script type="text/javascript" src="<?php echo __ROOT__;?>/hd/Hdcms/Admin/Data/Field/number/validate.js"></script>
<table class="table1">
    <tr class="input action">
        <th class="w400">参数</th>
        <td>
            <table class="table1">
                <tr>
                    <td class="w100">整数位数</td>
                    <td><input type="text" name="set[num_integer]"  class="w100 num_integer" value="<?php echo $field['set']['num_integer'];?>"/></td>
                </tr>
                <tr>
                    <td class="w100">小数位数</td>
                    <td><input type="text" name="set[num_decimal]" class="w100 num_decimal" value="<?php echo $field['set']['num_decimal'];?>"/></td>
                </tr>
                <tr>
                    <td class="w100">显示长度</td>
                    <td><input type="text" name="set[size]" class="w100 num_size" value="<?php echo $field['set']['size'];?>"/> px</td>
                </tr>
                <tr>
                    <td>默认值</td>
                    <td><input type="text" name="set[default]" class="w200" value="<?php echo $field['set']['default'];?>"/></td>
                </tr>
            </table>
        </td>
    </tr>
    
</table>