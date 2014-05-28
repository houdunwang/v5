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
 * 日期处理类
 * @package     tools_class
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
final class Date{
    private $runtime = array(); //运行时间
    /**
     * 运行时间
     * @param type $start       开始标记
     * @param type $end         结束标记
     * @param type $decimals   运行时间的小数位数
     * @return type
     */

    static function runTime($start, $end = '', $decimals = 3) {
        if ($end != '') {
            self::$runtime [$end] = microtime();
            return number_format(self::$runtime [$end] - self::$runtime [$start], $decimals);
        }
        $runtime [$start] = microtime();
    }

}

?>
