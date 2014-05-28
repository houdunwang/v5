<?php

/**
 * 插件管理
 * Class PluginModel
 */
class PluginModel extends Model
{
    //节点菜单表
    public $table = 'plugin';
    /**
     * 安装插件
     * @param $plugin_name 插件名称(即插件应用目录名)
     */
    public function install_plugin($plugin_name)
    {
        //检测插件是否已经存在
        if (M('node')->where(array('app_group' => 'Plugin', 'app' => $plugin_name))->find()) {
            //创建表
            $this->error = '插件已经存在，请删除后再安装';
        } else {
            if (M()->runSql(file_get_contents('hd/Plugin/' . $plugin_name . '/Data/install.sql'))) {
                $data = require 'hd/Plugin/' . $plugin_name . '/Config/config.php';
                $data = array_change_key_case_d($data);
                $data['app'] = $plugin_name; //应用名
                $data['install_time'] = date("Y-m-d"); //安装时间
                //添加菜单
                if ($this->add($data)) {
                    $data = array(
                        'title' => $data['name'], //节点名称
                        'app_group' => 'Plugin', //应用组
                        'app' => $plugin_name, //应用名称
                        'control' => 'Manage', //默认控制器
                        'method' => 'index', //默认方法
                        'state' => 1, //状态
                        'pid' => 94, //父级菜单id(正在使用)
                        'plugin' => 1, //是否为插件
                        'type' => 2, //普通菜单
                    );
                    return $this->table('node')->add($data);
                }
            } else {
                $this->error = '插入数据失败';
            }
        }
    }

  
}