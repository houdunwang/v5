<?php
if (!defined("HDPHP_PATH")) exit('No direct script access allowed');
/**
 * Copyright    [HDPHP框架] (C)2011-2012 houdunwang.com ,Inc.
 * Licensed     www.apache.org/licenses/LICENSE-2.0
 * Encoding     UTF-8
 * Version      $Id: setupControl.php   2012-12-5
 * @author      向军  houdunwangxj@gmail.com
 * Link         www.hdphp.com
 */
//安装控制器
class SetupControl extends Control
{

    function __auto()
    {
        header("Content-type:text/html;charset=utf-8");
        if (is_file("lock.php")) {
            exit("<div style='border:solid 1px #dcdcdc;font-size:14px;font-family:\"微软雅黑\";padding:20px;'>不可进行RBAC配置，请先删除Setup目录中的lock.php文件</div>");
        }
    }
}

?>
