<?php
/**
 * 后台网站配置管理
 * Class ConfigControl
 * @author 向军 <houdunwangxj@gmail.com>
 */
class ConfigControl extends AuthControl
{
    private $_db;

    public function __init()
    {
        $this->_db = K("Config");
    }

    //修改
    function edit()
    {
        if (IS_POST) {
            //改变允许上传大小为字节
            foreach ($_POST AS $id => $value) {
                $this->_db->save(array("id" => $id, "value" => $value));
            }
            if (!is_writable("./data/config")) {
                $this->ajax(array("state" => 0, "message" => "./data/config目录没有写权限！"));
            } else {
                $config = $this->_db->all();
                $data = array();
                foreach ($config as $c) {
                    $data[$c['name']] = $c['value'];
                }
                //写入配置文件
                $data = "<?php if (!defined('HDPHP_PATH')) exit; \nreturn " .
                    var_export($data, true) . ";\n?>";
                file_put_contents("./data/config/config.inc.php", $data);
                $this->ajax(array("state" => 1, "message" => "修改配置文件成功"));
            }
        } else {
            $config = array();
            //站点配置
            $config['web'] = $this->_db->all("type=1");
            //伪静态
            $config['rewrite'] = $this->_db->all("type='伪静态'");
            //高级设置
            $config['grand'] = $this->_db->all("type=2");
            //上传配置
            $config['upload'] = $this->_db->all("type=3");
            //会员设置
            $config['member'] = $this->_db->all("type=4");
            //邮箱配置
//            $config['email'] = $this->_db->all("type=5");
            //安全设置
            $config['safe'] = $this->_db->all("type=6");
            //水印设置
            $config['water'] = $this->_db->all("type=7");
            //内容相关
            $config['content'] = $this->_db->all("type=8");
            //性能优化
            $config['optimize'] = $this->_db->all("type=9");
            foreach ($config as $n => $conf) {
                foreach ($conf as $m => $c) {
                    //会员角色
                    if ($c['id'] == 121) {
                        $group = $this->_db->table("role")->where("admin=0")->all();
                        $config[$n][$m]['html'] = <<<str
                                <tr>
                                    <th class="w150">{$c['title']}</th>
                                    <td class="w250">
                                       <select name="121">
str;
                        foreach ($group as $g) {
                            $checked = $c['value'] == $g['rid'] ? "selected='selected'" : "";
                            $config[$n][$m]['html'] .= "<option value='{$g['rid']}' {$checked}>{$g['rname']}</option>";
                        }
                        $config[$n][$m]['html'] .= <<<str
                                    </select>
                                    </td>
                                    <td>
                                        {$c['name']}
                                    </td>
                                </tr>
str;
                        continue;
                    }
                    //水印位置
                    if ($c['id'] == 133) {
                        ob_start();
                        require TPL_PATH . 'Config/water.php';
                        $con = ob_get_clean();
                        $config[$n][$m]['html'] = $con;
                        continue;
                    }
                    switch ($c['show_type']) {
                        //文本
                        case '文本':
                            $config[$n][$m]['html'] = <<<str
                                <tr>
                                    <th class="w150">{$c['title']}</th>
                                    <td class="w250">
                                        <input type="text" name="{$c['id']}" value="{$c['value']}" class="w400"/>
                                    </td>
                                    <td>
                                        变量名: <strong>{$c['name']}</strong>
                                        <span class='validate-message'>{$c['message']}</span>
                                    </td>
                                </tr>
str;
                            break;
                        //数字
                        case '数字':
                            $config[$n][$m]['html'] = <<<str
                                <tr>
                                    <th class="w150">{$c['title']}</th>
                                    <td class="w250">
                                        <input type="text" name="{$c['id']}" value="{$c['value']}" class="w400"/>
                                    </td>
                                    <td>
                                        {$c['name']}
                                    </td>
                                </tr>
str;
                            break;
                        //布尔
                        case '布尔(1/0)':
                            $_no = $_yes = "";
                            if ($c['value'] == 1) {
                                $_yes = "checked='checked'";
                            } else {
                                $_no = "checked='checked'";
                            }
                            $config[$n][$m]['html'] = <<<str
                                <tr>
                                    <th class="w150">{$c['title']}</th>
                                    <td class="w250">
                                        <label><input type="radio" name="{$c['id']}" value="1" $_yes/> 是</label>
                                        <label><input type="radio" name="{$c['id']}" value="0" $_no/> 否</label>
                                    </td>
                                    <td>
                                        变量名：{$c['name']} <span class='validate-message'>{$c['message']}</span>
                                    </td>
                                </tr>
str;
                            break;
                        //多行文本
                        case '多行文本':
                            $config[$n][$m]['html'] = <<<str
                                <tr>
                                    <th class="w150">{$c['title']}</th>
                                    <td class="w250">
                                        <textarea class="w400 h100" name="{$c['id']}">{$c['value']}</textarea>
                                    </td>
                                    <td>
                                        {$c['name']}
                                    </td>
                                </tr>
str;
                            break;
                    }
                }
            }
            $this->assign("config", $config);
            $this->display();
        }
    }
}






































