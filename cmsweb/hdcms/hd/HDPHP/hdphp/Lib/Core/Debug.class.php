<?php
// .-----------------------------------------------------------------------------------
// |  Software:[HDPHP framework]
// |   Version: 2013.01
// |      Site: http://www.hdphp.com
// |-----------------------------------------------------------------------------------
// |    Author: 向军 <houdunwangxj@gmail.com>
// | Copyright (c) 2012-2013, http://houdunwang.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
// |   License: http://www.apache.org/licenses/LICENSE-2.0
// '-----------------------------------------------------------------------------------
/**
 * debug调式处理类
 * @package     Core
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
final class Debug
{

    //信息内容
    static $info = array();
    //运行时间
    static $runtime;
    //运行内存占用
    static $memory;
    //内存峰值
    static $memory_peak;
    //所有发送的SQL语句
    static $sqlExeArr = array();
    //编译模板
    static $tpl = array();
    //缓存记录
    static $cache=array("write_s"=>0,"write_f"=>0,"read_s"=>0,"read_f"=>0);


    /**
     * 项目调试开始
     * @access public
     * @param type $start   起始
     * @return void
     */
    static public function start($start)
    {
        self::$runtime[$start] = microtime(true);
        if (function_exists("memory_get_usage")) {
            self::$memory[$start] = memory_get_usage();
        }
        if (function_exists("memory_get_peak_usage")) {
            self::$memory_peak[$start] = false;
        }
    }

    /**
     * 运行时间
     * @param string $start 起始标记
     * @param string $end   结束标记
     * @param int $decimals 小数位
     * @return void
     * @throws exceptionHD
     */
    static public function runtime($start, $end = '', $decimals = 4)
    {
        if (!isset(self::$runtime[$start])) {
            throw new exceptionHD('没有设置调试开始点：' . $start);
        }
        if (empty(self::$runtime[$end])) {
            self::$runtime[$end] = microtime(true);
            return number_format(self::$runtime[$end] - self::$runtime[$start], $decimals);
        }
    }

    /**
     * 项目运行内存峰值
     * @access public
     * @param string $start   起始标记
     * @param string $end     结束标记
     * @return int
     */
    static public function memory_perk($start, $end = '')
    {
        if (!isset(self::$memory_peak[$start]))
            return mt_rand(200000, 1000000);
        if (!empty($end))
            self::$memory_peak[$end] = memory_get_peak_usage();
        return max(self::$memory_peak[$start], self::$memory_peak[$end]);
    }

    /**
     * 显示调试信息
     * @access public
     * @param string $start   起始标记
     * @param string $end     结束标记
     * @return void
     */
    static public function show($start, $end)
    {
        $debug = array();
        $debug['file'] = require_cache();
        $debug['runtime'] = self::runtime($start, $end);
        $debug['memory'] = number_format(self::memory_perk($start, $end) / 1000, 0) . " KB";
        require HDPHP_TPL_PATH . '/debug.php';
    }

}
