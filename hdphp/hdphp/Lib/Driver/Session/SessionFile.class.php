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
 * SESSION文件驱动
 * @package     Session
 * @subpackage  Driver
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */


class SessionFile extends SessionAbstract
{
    //初始
    public function run()
    {
        if (C("SESSION_SAVE_PATH")) {
            session_save_path(C("SESSION_SAVE_PATH"));
        }
        if (!session_save_path()) {
            dir::create(TEMP_ . '/session');
            session_save_path(ROOT_PATH . '/session');
        }
        session_name(C("SESSION_NAME"));
        session_set_save_handler(
            array(&$this, "open"),
            array(&$this, "close"),
            array(&$this, "read"),
            array(&$this, "write"),
            array(&$this, "destroy"),
            array(&$this, "gc")
        );
    }

    //打开
    public function open()
    {
        return true;
    }

    //读取
    public function read($sid)
    {
        $session = session_save_path() . '/hdsess_' . $sid;
        if (!is_file($session)) {
            return false;
        }
        return file_get_contents($session);
    }

    //写入
    public function write($sid, $data)
    {
        $session = session_save_path() . '/hdsess_' . $sid;
        return file_put_contents($session, $data) ? true : false;
    }

    //卸载
    public function destroy($sid)
    {
        $session = session_save_path() . '/hdsess_' . $sid;
        if (is_file($session)) {
            unlink($session);
        }
    }

    //垃圾回收
    public function gc()
    {
        $path = session_save_path();
        foreach (glob($path . "/*") as $file) {
            if (strpos($file, "hdsess_") === false) continue;
            if (filemtime($file) + C("SESSION_LIFETIME") < time()) {
                unlink($file);
            }
        }
        return true;
    }

    //关闭
    public function close()
    {
        //关闭SESSION
        if (mt_rand(1, C("SESSION_GC_DIVISOR")) == 1) {
            $this->gc();
        }
        return true;
    }

}

?>
