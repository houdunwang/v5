<?php
if (!defined('HDPHP_PATH'))
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
 * 视图处理抽象层
 * @package     View
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
abstract class View
{

    /**
     * 获得模版文件
     */
    protected function getTemplateFile($file)
    {
        if (is_null($file)) {
            $file = TPL_PATH . CONTROL . '/' . METHOD;
        } else if (!strstr($file, '/')) {
            $file = TPL_PATH . CONTROL . '/' . $file;
        }
        //添加模板后缀
        if (!preg_match('@\.[a-z]+$@', $file))
            $file .= C('TPL_FIX');
        //将目录全部转为小写
        if (is_file($file)) {
            return $file;
        } else {
            //模版文件不存在
            if (DEBUG)
                halt("模板不存在:$file");
            else
                return null;
        }
    }

}

?>