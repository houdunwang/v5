<tr>
    <th class="w150"><?php echo $c['title']; ?></th>
    <td>
        <table class="w300 table3">
            <tr>
                <td>
                    <label><input type="radio" name="133" value="1"
                                  <?php if ($c['value'] == 1){ ?>checked="checked"<?php } ?>
                            /> 左上</label>
                </td>
                <td>
                    <label><input type="radio" name="133" value="2"
                                  <?php if ($c['value'] == 2){ ?>checked="checked"<?php } ?>
                            /> 上中</label>
                </td>
                <td>
                    <label><input type="radio" name="133" value="3"
                                  <?php if ($c['value'] == 3){ ?>checked="checked"<?php } ?>
                            /> 上右</label>
                </td>
            </tr>
            <tr>
                <td>
                    <label><input type="radio" name="133" value="4"
                                  <?php if ($c['value'] == 4){ ?>checked="checked"<?php } ?>
                            /> 中左</label>
                </td>
                <td>
                    <label><input type="radio" name="133" value="5"
                                  <?php if ($c['value'] == 5){ ?>checked="checked"<?php } ?>
                            /> 中间</label>
                </td>
                <td>
                    <label><input type="radio" name="133" value="6"
                                  <?php if ($c['value'] == 6){ ?>checked="checked"<?php } ?>
                            /> 中右</label>
                </td>
            </tr>
            <tr>
                <td>
                    <label><input type="radio" name="133" value="7"
                                  <?php if ($c['value'] == 7){ ?>checked="checked"<?php } ?>
                            /> 下左</label>
                </td>
                <td>
                    <label><input type="radio" name="133" value="8"
                                  <?php if ($c['value'] == 8){ ?>checked="checked"<?php } ?>
                            /> 下中</label>
                </td>
                <td>
                    <label><input type="radio" name="133" value="9"
                                  <?php if ($c['value'] == 9){ ?>checked="checked"<?php } ?>
                            /> 下右</label>
                </td>
            </tr>
        </table>
    </td>
</tr>