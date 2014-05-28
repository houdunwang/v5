<?php
/**
 * Copyright    [HDPHP框架] (C)2011-2012 houdunwang.com ,Inc.
 * Licensed     www.apache.org/licenses/LICENSE-2.0
 * Encoding     UTF-8
 * Version      $Id: sessionControl.php   2012-12-5
 * @author      向军  houdunwangxj@gmail.com
 * Link         www.hdphp.com
 */
//session控制器
class SessionControl extends AuthControl
{
    function index()
    {
        $this->display();
    }

    function checkdb()
    {
        C(include APP_PATH . '/Config/config.php');
        $host = C("db_host") . ':' . C("db_port");
        $stat = mysql_connect($host, C("db_user"), C("db_password")) ? 1 : 0;
        if (!mysql_select_db(C("db_database"))) {
            $this->error("数据库连接错误，请修改配置项");
        }
        return $stat;
    }

    function createsessiontable()
    {
        if (!$this->checkdb()) {
            $this->error("连接参数不对，请重新设置");
        }
        $this->addrbactable();
    }

    function addrbactable()
    {
        $sql = file_get_contents(APP_PATH . 'Data/session.sql');
        $tbfix = C("db_prefix");
        $sql = str_replace("hd_", $tbfix, $sql);
        $sqlArr = explode(';', $sql);
        $sqlArr = array_filter($sqlArr);
        $db = M();
        foreach ($sqlArr as $v) {
            $db->exe($v);
        }
        $this->success("创建SESSION表完成");
    }

}

?>
