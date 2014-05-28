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
 * 字符串处理类
 * @package     tools_class
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
class Mobile
{
    /**
     * 手机号码查询
     * */
    static function area($mob)
    {
        $mob = substr($mob, 0, 7);
        $dat = file_get_contents(HDPHP_EXTEND_PATH . "Org/Mobile/mobile.Dat");
        $string = strstr($dat, $mob);
        $num = strpos($string, "\n");
        if (!$num)
            return false;
        $end = substr($string, 0, $num);
        list($a, $area) = explode(",", $end);
        $toCharset = C("charset");
        if (preg_match("/utf8|utf-8/i", $toCharset)) {
            $toCharset = "UTF-8";
        }
        return iconv("gbk", $toCharset, $area);
    }
}

?>