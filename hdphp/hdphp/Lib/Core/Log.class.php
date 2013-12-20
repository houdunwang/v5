<?php
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
 * 日志处理类
 * @package     Core
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
class Log
{

    static $log = array();

    /**
     * 记录日志内容
     * @param string $message 内容
     * @param int $logType 类型
     */
    static public function set($message, $logType)
    {
        //获得日志类型
        $type = substr(FriendlyErrorType($logType), 2);
        if (in_array($type, array_change_value_case(C("LOG_TYPE"), 1))) {
            self::$log[] = $message . "\n";
        }
    }

    /**
     * 存储日志内容
     * @access public
     * @param int $type 处理方式
     * @param string $destination 日志文件
     * @param type $extraHeaders 额外信息（发送邮件）
     * @return void
     */
    static public function save($type = 3, $destination = NULL, $extraHeaders = NULL)
    {
        if (is_null($destination)) {
            $destination = LOG_PATH . date("Y-m-d") . '-' . substr(md5(C("LOG_KEY")), 0, 5) . ".log";
        }
        if ($type == 3) {
            if (is_file($destination) && filesize($destination) > C("LOG_SIZE")) {
                //日志文件超过大小时的处理
                $num = count(glob(LOG_PATH . date("Y-m-d") . '-' . substr(md5(C("LOG_KEY")), 0, 5) . "-*")); //当日共有几个文件
                rename($destination, substr($destination, 0, -4) . "-" . $num . ".log");
            }
        }
        is_dir(LOG_PATH) or @dir_create(LOG_PATH);
        error_log(implode("", self::$log), $type, $destination, $extraHeaders);
        self::$log = array();
    }

    /**
     * 写入日志内容
     * @access public
     * @param string $message       日志内容
     * @param int $type             处理方式
     * @param string $destination   日志文件
     * @param null $extraHeaders
     * @return void
     */
    static public function write($message, $type = 3, $destination = NULL, $extraHeaders = NULL)
    {
        Dir::create(LOG_PATH);
        if (is_null($destination)) {
            $destination = LOG_PATH . date("Y-m-d") . '-' . substr(md5(C("LOG_KEY")), 0, 5) . ".log";
        }
        if ($type == 3) {
            if (is_file($destination) && filesize($destination) > C("LOG_SIZE")) {
                //日志文件超过大小时的处理
                $num = count(glob(LOG_PATH . date("Y-m-d") . '-' . substr(md5(C("LOG_KEY")), 0, 5) . "-*")); //当日共有几个文件
                rename($destination, substr($destination, 0, -4) . "-" . $num . ".log");
            }
        }
        is_dir(LOG_PATH) or @dir_create(LOG_PATH);
        error_log($message."\n", $type, $destination, $extraHeaders = null);
    }

}