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
 * 生成静态文件处理类
 * Class html
 * @package     tools_class
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
final class html
{

    /**
     * 生成静态页面
     * <code>
     * array(控制器名，方法名，表态数据，保存表态文件路径）
     * array(news,show,1,'h/b/Hd.html');表示生成news控制器中的show方法生成ID为1的文章
     * </code>
     * @param $control 控制器，需要事先加载
     * @param $method 方法
     * @param $field 数据array("aid"=>1,"_html"=>"html/2013/2/22/1.html")
     * @return bool
     */
    static public function make($control, $method, $field)
    {
        if (!class_exists($control) or !method_exists($control, $method)) {
            halt("静态生成需要的控制器{$control}或方法{$method}不存在");
        }
        if (!isset($field['_html'])) {
            halt("请指定静态文件参数'_html',请参考后盾HD框架手册");
        }
        $obj = NULL;
        if (!$obj) $obj = new $control;
        //************创建GET数据****************
        $_GET = array_merge($_GET, $field);
        $htmlPath = dirname($field['_html']); //生成静态目录
        if (!dir_create($htmlPath)) { //创建生成静态的目录
            halt("创建目录失败，请检查目录权限");
            return false;
        }
        ob_start();
        $obj->$method(); //执行控制器方法
        $content = ob_get_clean();
        file_put_contents($field['_html'], $content);
        return true;
    }

    /**
     * 批量生成静态文件
     * @param $data 数据
     * @return bool
     */
    static public function makeAll($data)
    {
        if (empty($data) || !is_array($data)) return false;
        foreach ($data as $d) {
            self::make($d[0], $d[1], $d[2]);
        }
        return true;
    }
}

?>