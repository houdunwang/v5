<?php

if (!defined("HDPHP_PATH"))
    exit('No direct script access allowed');

// .---------------------------------------------------------------------------.
// |  Software: [HDPHP framework]                                              |
// |   Version: 2013.01                                                        |
// |      Site: http://www.hdphp.com                                           |
// | ------------------------------------------------------------------------- |
// |    Author: hdxj <houdunwangxj@gmail.com>                                  |
// | Copyright (c) 2012-2013, http://houdunwang.com. All Rights Reserved.      |
// | ------------------------------------------------------------------------- |
// |   License: http://www.apache.org/licenses/LICENSE-2.0                     |
// '---------------------------------------------------------------------------'

/**
 * 缓存处理类
 * 缓存驱动类均继承此类
 * @package     Cache
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
class Cache
{

    protected $isConnect = false; //联接状态
    protected $options = array(); //参数

    /**
     * 设置连接驱动
     * @param array $options 参数
     * @return obj
     */
    static public function init($options = array())
    {
        return CacheFactory::factory($options); //获得缓存操作对象
    }

    /**
     * 魔术方法获得缓存
     * <code>
     * $Cache  = Cache::init();
     * $Cache->b = 'houdunwang.com';
     * echo $Cache->b;
     * </code>
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * * 设置缓存
     * @access public
     * <code>
     * $Cache  = Cache::init();
     * $Cache->b = 'houdunwang.com';
     * echo $Cache->b;
     * </code>
     * @param string $name 缓存KEY
     * @param mixed $value VALUE
     * @return boolean
     */
    public function __set($name, $value)
    {
        return $this->set($name, $value);
    }

    /**
     * 访问私有方法时执行
     * @param string $method 方法名称
     * @param mixed $args 方法值
     * @return bool|mixed
     */
    public function __call($method, $args)
    {
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $args);
        }
        return false;
    }

    /**
     * 删除缓存
     * @access public
     * @param string $name  缓存KEY
     * @return boolean  删除成功或失败
     */
    public function __unset($name)
    {
        return $this->del($name);
    }

    /**
     * 设置与获得属性
     * 当设置的值$value=NULL时为获得配置项
     * 否则为设置缓存配置
     * @access public
     * @param string $name  缓存配置名称
     * @param mixed $value   设置缓存的值
     * @return boolean|null
     */
    public function options($name, $value = null)
    {
        if (!is_null($value)) {
            $this->options[$name] = $value;
            return true;
        } else {
            if (isset($this->options[$name])) {
                return $this->options[$name];
            } else {
                return null;
            }
        }
    }

    /**
     * 缓存队列
     * 缓存队列即设置可以缓存的最大数量，以先进先删除原则处理队列垃圾
     * @param $name key名称
     * @return mixed
     */
    protected function queue($name)
    {
        static $drivers = array(
            "file" => "F"
        );
        $driver = isset($this->options['Driver']) ? $this->options['Driver'] : 'file';
        $_queue = $drivers[$driver][0]("hdphp_queue");
        if (!$_queue) {
            $_queue = array();
        }
        array_push($_queue, $name);
        $hdphp_queue = array_unique($_queue);
        //超过队列允许最大值
        if (count($hdphp_queue) > $this->options['length']) {
            $gc = array_shift($hdphp_queue);
            if ($gc)
                $this->del($gc);
        }
        return $drivers[$driver][0]("hdphp_queue", $hdphp_queue);
    }

    /**
     * @param int $type 记录类型  1写入 2读取
     * @param int $stat 状态  0失败 1成功
     */
    protected function record($type, $stat = 1)
    {
        if (!DEBUG && !C("SHOW_CACHE")) return;
        if ($type === 1) {
            $stat ? Debug::$cache['write_s']++ : Debug::$cache['write_f']++;
        } else {
            $stat ? Debug::$cache['read_s']++ : Debug::$cache['read_f']++;
        }
    }
}

?>