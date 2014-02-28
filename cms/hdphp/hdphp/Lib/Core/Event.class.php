<?php
// .-----------------------------------------------------------------------------------
// |  Software: [HDPHP framework]
// |   Version: 2013.05
// |      Site: http://www.hdphp.com
// |-----------------------------------------------------------------------------------
// |    Author: 向军 <houdunwangxj@gmail.com>
// | Copyright (c) 2012-2013, http://www.houdunwang.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
// |   License: http://www.apache.org/licenses/LICENSE-2.0
// '-----------------------------------------------------------------------------------
/**
 * 事件基类
 * @category HDPHP
 * @package HDPHP
 * @subpackage core
 * @author hdxj <houdunwangxj@gmail.com>
 */
abstract class Event
{
    abstract function run(&$param);

    //事件参数
    protected $options = array();

    //构造函数
    public function __construct()
    {
        if (!empty($this->options)) {
            foreach ($this->options as $name => $value) {
                if (is_null(C($name))) {
                    C($name, $this->options[$name]);
                } else {
                    $this->options[$name] = C($name);
                }
            }
        }
    }
}