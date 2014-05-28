<script type="text/javascript" src="<?php echo __ROOT__;?>/hd/Hdcms/Admin/Data/Field/<?php echo $field_type;?>/validate.js"></script>
<table class="table1">
    <tr class="input action">
        <th class="w400">参数</th>
        <td>
            <table class="table1">
            	<tr>
                    <td>类型</td>
                    <td>
                    	<label><input type="radio" name="set[field_type]" value="smallint"/> smallint</label>
                    	<label><input type="radio" name="set[field_type]" value="int" checked=""/> int</label>
                    	<label><input type="radio" name="set[field_type]" value="mediumint"/> mediumint</label>
                    	<label><input type="radio" name="set[field_type]" value="decimal"/> decimal</label>
                    </td>
                </tr>
                <tr>
                    <td class="w100">整数位数</td>
                    <td><input type="text"  name="set[num_integer]" class="w100 num_integer" value="6"/></td>
                </tr>
                <tr>
                    <td class="w100">小数位数</td>
                    <td><input type="text"   name="set[num_decimal]" class="w100 num_decimal" value="2"/></td>
                </tr>
                <tr>
                    <td class="w100">显示长度</td>
                    <td><input type="text"   name="set[size]" class="w100 num_size" value="300"/></td>
                </tr>
                <tr>
                    <td>默认值</td>
                    <td><input type="text" name="set[default]" class="w200"/></td>
                </tr>
            </table>
        </td>
    </tr>
</table>