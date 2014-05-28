<?php
if (!defined("PATH_HD")) exit('No direct script access allowed');
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
 * session处理类
 * 推荐使用session()函数完成处理
 * @package     tools_class
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
final class Session
{

    /**
     *  开启SESSION
     *  系统会对SESSION开启状态进行自动配置，所以这个方法不要使用
     */
    static function start()
    {
        session_id() || session_start();
    }


    /**
     * 返回SESSION_NAME的值
     * @return type
     */
    static function getSessionName()
    {
        self::start();
        return session_name();
    }

    /**
     * 获得SESSION_ID
     * @return string
     */
    static function getSessionId()
    {
        self::start();
        return session_id();
    }


    /**
     * 删除所有SESSION值，释放SESSION_ID
     */
    static function destroy()
    {
        self::start();
        session_unset();
        session_destroy();
    }

    /**
     * 设置SESSION存储路径
     * @param type $path
     */
    static function setSavePath($path)
    {
        self::start();
        if (!is_dir($path)) {
            Dir::create($path);
        }
        session_save_path($path);
    }


    /**
     *  设置SESSION_ID生命周期
     * @param type $time    SESSION生命周期，秒数
     */
    static function setCookie($time = null)
    {
        $SESSION_COOKIE_LIFETIME = is_null($time) ? C("SESSION_COOKIE_LIFETIME") : $time;
        if ((int)$SESSION_COOKIE_LIFETIME > 0) {
            setcookie(session_name(), session_id(), time() + $SESSION_COOKIE_LIFETIME, '/');
        }
    }

}

?>
