<script type="text/javascript" src="<?php echo __ROOT__;?>/hd/Hdcms/Admin/Data/Field/files/validate.js"></script>
<table class="table1">
    <tr class="input action">
        <th class="w400">参数</th>
        <td>
            <table class="table1">
                <tr>
                    <td class="w100">允许上传的个数</td>
                    <td>
                        <input type="text" class="w100" name="set[num]" value="<?php echo $field['set']['num'];?>"/>
                    </td>
                </tr>
                <tr>
                    <td class="w100">上传文件类型</td>
                    <td>
                        <input type="text" class="w200" name="set[filetype]" value="<?php echo $field['set']['filetype'];?>"/>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>