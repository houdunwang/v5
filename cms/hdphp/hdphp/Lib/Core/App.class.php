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
final class App
{
    /**
     * 运行应用
     * @access public
     * @reutrn mixed
     */
    public static function run()
    {
        //session处理
        session(C("SESSION_OPTIONS"));
        //加载应用与事件处理类
        self::loadEventClass();
        //执行应用开始事件
        event("APP_START");
        //Debug Start
        DEBUG and Debug::start("APP_START");
        self::start();
        //Debug End
        DEBUG and Debug::show("APP_START", "APP_END");
        //日志记录
        Log::save();
        event("APP_END");
    }

    //加载应用与模块end事件类
    static private function loadEventClass()
    {
        $app_end_event = C("app_event.app_end");
        if ($app_end_event) {
            foreach ($app_end_event as $c) {
                HDPHP::autoload($c . 'Event');
            }
        }
        $content_end_event = C("app_event.control_end");
        if ($content_end_event) {
            foreach ($content_end_event as $c) {
                HDPHP::autoload($c . 'Event');
            }
        }
    }

    /**
     * 运行应用
     * @access private
     */
    static private function start()
    {
        //控制器实例
        $control = control(CONTROL);
        //控制器不存在
        if (!$control) {
            //应用组检测
            if(IS_GROUP and !is_dir(GROUP_PATH.GROUP_NAME)){
                _404('应用组' . GROUP_PATH.GROUP_NAME . '不存在');
            }
            //应用检测
            if(!is_dir(APP_PATH)){
                _404('应用' . APP . '不存在');
            }
            //空控制器
            $control = Control("Empty");
            if (!$control) {
                _404('模块' . CONTROL .C("CONTROL_FIX") .'不存在');
            }
        }
        //执行动作
        try {
            $method = new ReflectionMethod($control, METHOD);
            if ($method->isPublic()) {
                $method->invoke($control);
            } else {
                throw new ReflectionException;
            }
        } catch (ReflectionException $e) {
            $method = new ReflectionMethod($control, '__call');
            $method->invokeArgs($control, array(METHOD, ''));
        }
    }
}

?>