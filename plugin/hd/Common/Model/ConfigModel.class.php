<?php
/**
 * 权限模型
 * Class AccessModel
 * @author hdxj <houdunwangxj@gmail.com>
 */
class ConfigModel extends Model
{
    public $table = "config";

    public function __init()
    {
    }
    //更新配置文件
    public function  update_config_file()
    {
        //写入配置文件
        $config = $this->all();
        $data = array();
        foreach ($config as $c) {
            $data[$c['name']] = $c['value'];
        }
        $data = "<?php if (!defined('HDPHP_PATH')) exit; \nreturn " .
            var_export($data, true) . ";\n?>";
        return file_put_contents("./data/config/config.inc.php", $data);
    }
}