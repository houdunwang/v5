<script type="text/javascript" src="<?php echo __ROOT__;?>/hd/Hdcms/Admin/Data/Field/image/validate.js"></script>
<table class="table1">
    <tr class="input action">
        <th class="w400">参数</th>
        <td>
            <table class="table1">
                <tr>
                    <td class="w100">图片最大宽度</td>
                    <td>
                        <label><input type="text" class="w100 image_height" name="set[upload_img_max_width]" value="<?php echo $field['set']['upload_img_max_width'];?>"/> </label>
                    </td>
                </tr>
                <tr>
                    <td class="w100">图片最大高度</td>
                    <td>
                        <label><input type="text" class="w100 image_width" name="set[upload_img_max_height]" value="<?php echo $field['set']['upload_img_max_height'];?>"/></label>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>