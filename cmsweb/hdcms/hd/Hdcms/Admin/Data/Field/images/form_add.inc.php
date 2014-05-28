<script type="text/javascript" src="<?php echo __ROOT__;?>/hd/Hdcms/Admin/Data/Field/<?php echo $field_type;?>/validate.js"></script>
<table class="table1">
    <tr class="input action">
        <th class="w400">参数</th>
        <td>
            <table class="table1">
                <tr>
                    <td class="w100">图片最大宽度</td>
                    <td>
                        <label>
                            <input type="text" class="w100" name="set[upload_img_max_width]" value="800"/>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td class="w100">图片最大高度</td>
                    <td>
                        <label>
                            <input type="text" class="w100" name="set[upload_img_max_height]" value="800"/>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>允许上传的个数</td>
                    <td>
                        <input type="text" class="w100" name="set[num]" value="10"/>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
</table>