<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
    <title>设置权限</title>
    <hdjs/>
    <js file="__CONTROL_TPL__/js/js.js"/>
    <css file="__CONTROL_TPL__/css/css.css"/>
</head>
<body>
<form action="{|U:'edit'}" method="post" class="hd-form" onsubmit="return hd_submit(this,'{|U:'Role/index'}')">
    <input type="hidden" name="rid" value="{$rid}"/>

    <div class="wrap">
        <div class="menu_list">
            <ul>
                <li><a href="{|U:'Role/index'}">角色列表</a></li>
                <li><a href="javascript:;" class="action">设置权限</a></li>
            </ul>
        </div>
        <div class="access">
            <ul>
                <list from="$access" name="a">
                    <li class="li1">
                        <h3> {$a.checkbox}</h3>
                        <?php if ($a['_data']): ?>
                            <ul class="level2">
                                <list from="$a._data" name="b">
                                    <li class="li2">
                                        <h4> {$b.checkbox}</h4>
                                        <?php if ($b['_data']): ?>
                                            <ul class="level3">
                                                <list from="$b._data" name="c">
                                                    <li>
                                                        {$c.checkbox}
                                                    </li>
                                                </list>
                                            </ul>
                                        <?php endif; ?>
                                    </li>
                                </list>
                            </ul>
                        <?php endif; ?>
                    </li>
                </list>
            </ul>
        </div>

    </div>
    <div class="position-bottom">
        <input type="submit" class="hd-success" value="确定"/>
    </div>
</form>
</body>
</html>