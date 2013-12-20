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
 * 视图处理抽象层
 * @package     View
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
abstract class View
{

    /**
     * 获得模版文件
     */
    protected function getTemplateFile($tplFile)
    {
        if (is_null($tplFile)) {
            $tplFile = METHOD . C("TPL_FIX");
        } else {
            if (count(explode("/", $tplFile)) > 2) {
                if (!preg_match('@\.[a-z]{3,4}$@i', $tplFile)) {
                    $tplFile .= C("TPL_FIX");
                }
                if (!is_file($tplFile)) {
                    DEBUG and error(L("view_getTemplateFile_error3") . $tplFile); //模版文件不存在
                }
                return $tplFile;
            }
            $tplFile = str_replace(C("TPL_FIX"), '', $tplFile) . C("TPL_FIX");
        }
        //配置文件tpl_dir包含路径 并且文件中不包含路径
        if (strstr(C("TPL_DIR"), '/') && !strstr($tplFile, '/')) {
            $tplFile = TPL_PATH . $tplFile;
        } else { //模板文件中包含
            $fileArr = explode("/", $tplFile);
            $file = array_pop($fileArr); //模版文件
            switch (count($fileArr)) {
                case 0:
                    $tplFile = TPL_PATH . CONTROL . '/' . $tplFile;
                    break;
                case 1:
                    $tplFile = TPL_PATH . $fileArr[0] . '/' . $file;
                    break;
                case 2:
                    $tplFile = str_replace(APP, $fileArr[0], TPL_PATH) . '/' . $fileArr[1] . '/' . $file;
                    break;
            }
        }
        //将目录全部转为小写
        if (!is_file($tplFile)) {
            halt(L("view_getTemplateFile_error3") . $tplFile); //模版文件不存在
        }
        return $tplFile;
    }

}

?>