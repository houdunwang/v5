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
    const FATAL = 'FATAL'; // 严重错误: 导致系统崩溃无法使用
    const ERROR = 'ERROR'; // 一般错误: 一般性错误
    const WARNING = 'WARNING'; // 警告性错误: 需要发出警告的错误
    const NOTICE = 'NOTICE'; // 通知: 程序可以运行但是还不够完美的错误
    const DEBUG = 'DEBUG'; // 调试: 调试信息
    const SQL = 'SQL'; // SQL：SQL语句 注意只在调试模式开启时有效
    //日志信息
    static $log = array();

    /**
     * 记录日志内容
     * @param $message 错误
     * @param string $level 级别
     * @param bool $record 是否记录
     */
    static public function record($message, $level = self::ERROR, $record = false)
    {
        if ($record || in_array($level, C('LOG_LEVEL'))) {
            self::$log[] = date("[ c ]") . "{$level}: {$message}\r\n";
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
        if (empty(self::$log)) return;
        if (is_null($destination)) {
            $destination = LOG_PATH . date("Y_m_d") . ".log";
        }
        if (is_dir(LOG_PATH)) error_log(implode("", self::$log) . "\r\n", $type, $destination, $extraHeaders);
        self::$log = array();
    }

    /**
     * 写入日志内容
     * @access public
     * @param string $message 日志内容
     * @param string $level 错误等级
     * @param int $type 处理方式
     * @param string $destination 日志文件
     * @param string $extraHeaders
     * @return void
     */
    static public function write($message, $level = self::ERROR, $type = 3, $destination = NULL, $extraHeaders = NULL)
    {
        if (is_null($destination)) {
            $destination = LOG_PATH . date("Y_m_d") . ".log";
        }
        if (is_dir(LOG_PATH)) error_log(date("[ c ]") . "{$level}: {$message}\r\n", $type, $destination, $extraHeaders);
    }

}