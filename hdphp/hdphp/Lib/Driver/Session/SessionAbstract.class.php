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
 * session处理抽象层
 * @package     Session
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
abstract class SessionAbstract
{

    abstract function open();

    abstract function read($sid);

    abstract function write($sid, $data);

    abstract function destroy($sid);

    abstract function gc();

    protected $sessionName; //COOKIE中的sessionName名称
    protected $sessionLifeTime; //SESSION 过期时间
    protected $sessionGcDivisor; //SESSION清理频率
    protected $card; //客户端验证密匙

    //构造函数

    public function __construct()
    {
        $this->init();
    }

//初始化SESSION环境
    public function init()
    {
        if (!ini_get("Session.auto_start")) {
            @ini_set('Session.use_trans_sid', 0); //禁止自动添加sid
            @ini_set('Session.auto_start', 0); //关闭自动开启
            @ini_set('Session.use_cookies', 1); //使用COOKIE
            @ini_set('Session.gc_maxlifetime', (int)C("SESSION_LIFETIME")); //过期时间
            @ini_set('Session.gc_divisor', (int)C("SESSION_GC_DIVISOR")); //加收概率
        }
        $this->setSessionName();
        $this->setSessionId();
        $this->sessionLifeTime = (int)C("SESSION_LIFETIME");
        $this->sessionGcDivisor = (int)C("SESSION_GC_DIVISOR");
        $this->card = md5($_SERVER['REMOTE_ADDR'] . (isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : ""));
        session_set_save_handler(
            array($this, "open"), array($this, "close"), array($this, "read"), array($this, "write"), array($this, "destroy"), array($this, "gc")
        );
    }

    //设置SESSION_NAME
    protected function setSessionName()
    {
        $this->sessionName = C("SESSION_NAME") ? C("SESSION_NAME") : session_name();
        session_name(C("SESSION_NAME"));
    }

    //设置SESSION_ID值考虑UPLOADIFY||swfupload
    protected function setSessionId()
    {
        if (isset($_GET[$this->sessionName])) {
            session_id($_GET[$this->sessionName]);
        } elseif (isset($_POST[$this->sessionName])) {
            session_id($_POST[$this->sessionName]);
        }
    }

    //关闭SESSION
    public function close()
    {
        if (mt_rand(1, $this->sessionGcDivisor) == 1) {
            $this->gc();
        }
        return true;
    }

}

?>