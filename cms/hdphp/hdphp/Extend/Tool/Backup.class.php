<?php
if (!defined("HDPHP_PATH"))
    exit('No direct script access allowed');
// .-----------------------------------------------------------------------------------
// |  Software: [HDPHP framework]
// |   Version: 2013.01
// |      Site: http://www.hdphp.com
// |-----------------------------------------------------------------------------------
// |    Author: 向军 <houdunwangxj@gmail.com>
// | Copyright (c) 2012-2013, http://houdunwang.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
// |   License: http://www.apache.org/licenses/LICENSE-2.0
// '-----------------------------------------------------------------------------------

/**
 * 数据库备份类
 * @package     tools_class
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
final class Backup
{
    //备份选项
    private static $config;
    //备份目录
    private static $dir;

    function __construct()
    {

    }

    //还原数据
    static public function recovery($option)
    {
        $dir = session("backup_dir",$option['dir']);
        self::$config = require($dir . '/config.php');
        //文件id
        $fid = session("backup_fid", NULL, "intval");
        //表前缀
        $db = M();
        $db_prefix = C("DB_PREFIX");
        if (is_null($fid)) {
            $url = isset($option['url']) ? $option['url'] : '';
            $step_time = (isset($option['step_time']) ? $option['step_time'] : 0.5) * 1000;
            //还原表结构
            if (is_file($dir . '/structure.php')) {
                require $dir . '/structure.php';
            }
            session('backup_fid',1);
            $html = "<script>setTimeout(function(){location.href='" . __METH__ . "';},{$step_time});</script>";
            $html .= "<html><head><meta charset='utf-8'/></head><body><div style='text-align:center;font-size:14px;margin-top: 50px;'>还原数据初始化...</div>";
            $html .= '</body></html>';
            session('backup_history_url', $url);
            session('backup_step_time', $step_time);
            echo $html;
            exit;
        }
        $step_time = session('backup_step_time');
        foreach (glob($dir . '/*') as $d) {
            if (preg_match("@_bk_$fid\.php$@", $d)) {
                require $d;
                $_SESSION['backup_fid']+=1;
                $html = "<script>setTimeout(function(){location.href='" . __METH__ . "';},{$step_time});</script>";
                $html .= "<html><head><meta charset='utf-8'/></head><body><div style='text-align:center;font-size:14px;margin-top: 50px;'>分卷{$fid}还原完毕!</div>";
                $html .= "</body></html>";
                echo $html;
                exit;
            }
        }
        $html = "<html><head><meta charset='utf-8'/></head><body><div style='text-align:center;font-size:14px;margin-top: 50px;'>所有分卷还原完毕!";
        $url = session('backup_history_url');
        if (!empty($url))
            $html .= "<a href='javascript:parent.location.href=\"" . $url . "\"' class='btn'>返回</a>";
        $html .= '</div></body></html>';
        self::success($html);
    }

    //备份数据表
    static public function backup($config = array())
    {
        $dir = session("backup_dir");
        if (!is_file($dir . '/config.php')) {
            session('backup_dir', NULL);
            $dir = NULL;
        }
        if ($dir) {
            self::$dir = $dir;
            if (is_file(self::$dir . '/config.php')) {
                self::$config = require(self::$dir . '/config.php');
            } else {
                if (DEBUG) {
                    halt('数据库备份配置文件不存在，请重新执行备份操作');

                } else {
                    return false;
                }
            }
        } else { //首次执行时创建配置文件
            self::$dir = isset($config['dir']) ? $config['dir'] : C('DB_BACKUP');
            self::init($config);
            //是否备份表结构
            $structure = isset($config['structure']) ? $config['structure'] : TRUE;
            if ($structure) {
                self::backup_structure();
            }
            session('backup_dir', self::$dir);
            $html = "<script>setTimeout(function(){location.href='" . __METH__ . "';},500);</script>";
            $html .= "<html><head><meta charset='utf-8'/></head><body><div style='text-align:center;font-size:14px;margin-top: 50px;'>正在进行备份初始化...</div></body></html>";
            echo $html;
            exit;
        }
        //执行备份
        self::backup_data();
    }

    //备份表结构
    static private function backup_structure()
    {
        $sql = "<?php if(!defined('HDPHP_PATH'))EXIT;\n";
        $db = M();
        $db_prefix = C("DB_PREFIX");
        foreach (self::$config as $table => $config) {
            $tmp = $db->query("SHOW CREATE TABLE $table");
            $create_table_sql = str_ireplace("`" . $db_prefix, "`\".\$db_prefix.\"", $tmp[0]['Create Table']);
            $sql .= "\$db->exe(\"DROP TABLE IF EXISTS `\".\$db_prefix.\"" . str_replace($db_prefix, '', $table) . "`\");\n";
            $sql .= "\$db->exe(\"{$create_table_sql}\");\n";
        }
        file_put_contents(self::$dir . '/structure.php', $sql);
    }

    //执行备份
    static private function backup_data()
    {
        foreach (self::$config as $table => $config) {
            //已经备份过的表忽略
            if ($config['success']) continue;
            //当前备份行
            $current_row = $config['current_row'];
            C('DB_DATABASE', $config['database']);
            $db = M($table, TRUE);
            $backup_str = "";
            do {
                $data = $db->limit($current_row, 20)->select();
                $current_row += 20;
                self::$config[$table]['current_row'] = $current_row;
                if (is_null($data)) {
                    self::$config[$table]['success'] = true;
                    self::write_backup_data($table, $backup_str, $current_row);
                    break;
                } else {
                    foreach ($data as $d) {
                        $table_name = "\".\$db_prefix.\"" . str_ireplace(C("DB_PREFIX"), "", $table);
                        $backup_str .= "\$db->exe(\"REPLACE INTO $table_name (`" . implode("`,`", array_keys($d)) . "`) VALUES('" . implode("','", array_values(addslashes_d($d))) . "')\");\n";
                    }
                }
                //文件超出分卷
                if (strlen($backup_str) > self::$config[$table]['size']) {
                    self::write_backup_data($table, $backup_str, $current_row);
                }
            } while (true);
        }
        //更新配置文件
        $html = "<html><head><meta charset='utf-8'/></head><body><div style='text-align:center;font-size:14px;margin-top: 50px;'>完成所有数据备份!";
        session('backup_dir',NULL);
        session('backup_fid',NULL);
        if (!empty($config['url']))
            $html .= "<a href='javascript:parent.location.href=\"" . $config['url'] . "\"' class='btn'>返回备份列表</a>";
        $html .= '</div></body></html>';
        self::success($html);
    }

    //写入备份数据
    static private function write_backup_data($table, $data, $current_row)
    {
        $fid = Q("session.backup_fid",1,'intval');
        file_put_contents(self::$dir . "/{$table}_bk_{$fid}.php", "<?php if(!defined('HDPHP_PATH'))EXIT;\n{$data}");
        self::next_backup($current_row, $table);
    }

    /**
     * 返回备份信息
     * @param $current_row 当前备份到的行
     * @param $table 当前备份的表
     */
    static private function next_backup($current_row, $table)
    {
        self::update_config_file();
        if (!headers_sent()) {
            header("Content-type:text/html;charset=utf-8");
        }
        //还原时间
        $c = current(self::$config);
        $step_time = $c['step_time'];
        $_SESSION['backup_fid']+=1;
        $html = "<script>setTimeout(function(){location.href='" . __METH__ . "';},{$step_time});</script>";
        $html .= "<html><head><meta charset='utf-8'/></head><body><div style='text-align:center;font-size:14px;margin-top: 50px;'>完成到{$current_row}条记录的备份，继续备份{$table}表</div></body></html>";
        echo $html;
        exit;
    }

    //备份或还原完毕
    static private function success($msg)
    {
        if (!headers_sent()) {
            header("Content-type:text/html;charset=utf-8");
        }
        echo $msg;
        exit;
    }

    //初始化
    static private function init($config)
    {
        is_dir(self::$dir) or Dir::create(self::$dir);
        self::$config = array();
        //没有设置表时，备份当前库所有表
        if (empty($config['table'])) {
            $info = M()->getTableInfo();
            $config['table'] = array();
            if (empty($info['table'])) {
                if (DEBUG) {
                    halt('数据库中没有任何表用于备份');
                } else {
                    return false;
                }
            }
            foreach ($info['table'] as $t => $v) {
                $config['table'][] = $t;
            }
        } else if (is_string($config['table'])) {
            //单一表，转为数组格式
            $config['table'] = array($config['table']);
        }
        if (!isset($config['size'])) {
            $config['size'] = 200; //分卷大小，单位kb
        }
        //跳转url
        $config['url'] = isset($config['url']) ? $config['url'] : '';
        //数据库
        $config['database'] = isset($config['database']) ? $config['database'] : C('DB_DATABASE');
        foreach ($config['table'] as $table) {
            $info = M()->getTableInfo(array($table));
            self::$config[$table] = array();
            //共有行数
            self::$config[$table]["row"] = $info['table'][$table]['rows'];
            //是否已经备份成功
            self::$config[$table]['success'] = false;
            //当前备份行
            self::$config[$table]['current_row'] = 0;
            self::$config[$table]['size'] = $config['size'] * 1000;
            self::$config[$table]['url'] = $config['url'];
            self::$config[$table]['step_time'] = isset($config['step_time']) ? $config['step_time'] * 1000 : 500;
            self::$config[$table]['database'] = $config['database'];
        }
        self::update_config_file();
    }

    //修改配置文件
    static function update_config_file()
    {
        //写入配置文件
        $s = "<?php if(!defined('HDPHP_PATH'))exit;\nreturn " . var_export(self::$config, true) . ";\n?>";
        file_put_contents(self::$dir . '/config.php', $s);
    }
}
