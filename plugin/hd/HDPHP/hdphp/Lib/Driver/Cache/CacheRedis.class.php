<?php

if (!defined("HDPHP_PATH"))
    exit('No direct script access allowed');
// .-----------------------------------------------------------------------------------
// |  Software: [HDPHP framework]
// |   Version: 2013.03
// |      Site: http://www.hdphp.com
// |-----------------------------------------------------------------------------------
// |    Author: 向军 <houdunwangxj@gmail.com>
// | Copyright (c) 2012-2013, http://houdunwang.com. All Rights Reserved.
// |-----------------------------------------------------------------------------------
// |   License: http://www.apache.org/licenses/LICENSE-2.0
// '-----------------------------------------------------------------------------------

/**
 * Redis缓存类
 * @package     Cache
 * @subpackage  Driver
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
class CacheRedis extends Cache {

    /**
     * 缓存对象
     * Redis缓存处理资源对象
     * @var Object
     */
    protected $RedisObj = array();

    /**
     * 构造函数
     * @access public
     * @param array $options 缓存选项必须为数组
     */
    public function __construct($options = array()) {
        //检测Redis扩展
        if (!extension_loaded('Redis')) {
            throw_exception("Redis扩展加载失败");
        }
        $this->options['expire'] = isset($options['expire']) ? intval($options['expire']) : intval(C("CACHE_TIME")); //缓存时间
        $this->options['prefix'] = isset($options['prefix']) ? $options['prefix'] : ''; //缓存前缀
        $this->options['length'] = isset($options['length']) ? $options['length'] : 0; //队列长度
        $this->options['zip'] = isset($options['zip']) ? $options['zip'] : TRUE; //队列长度
        $this->options['server'] = isset($options['server']) ? $options['server'] : C("CACHE_REDIS");
        $this->options['save'] = isset($options['save']) ? $options['save'] : true; //记录缓存命中率
        if (!$this->isConnect) {
            $this->connectRedis();
            $this->isConnect = true;
        }
    }

    /**
     * 连接Redis
     * @access private
     */
    private function connectRedis() {
        $host = $this->options['server'];
        $hostArr = is_array(current($host)) ? $host : array($host);
        foreach ($hostArr as $h) {
            $_host = isset($h['host']) ? $h['host'] : "127.0.0.1"; //主机
            $_port = isset($h['port']) ? $h['port'] : 6379; //端口
            $_pconnect = isset($h['pconnect']) ? $h['pconnect'] : 1; //持久连接
            $_password = isset($h['password']) ? $h['password'] : null; //密码
            $_timeout = isset($h['timeout']) ? $h['timeout'] : 1; //连接超时
            $_db = isset($h['Db']) ? $h['Db'] : 0; //数据库
            try {
                $this->RedisObj[$_host] = new Redis();
                $linkFunc = $_pconnect ? "pconnect" : "connect"; //是否持久连接
                $this->RedisObj[$_host]->$linkFunc($_host, $_port, $_timeout);
                if ($_password) {
                    if (!$this->RedisObj[$_host]->auth($_password)) {
                        throw new Exception();
                    }
                }
                $this->RedisObj[$_host]->select($_db);
            } catch (Exception $e) {
                if (C("DEBUG")) {
                    throw_exception("Redis{$_host} connection fails");
                }
                log::write($e->getMessage());
            }
        }
    }

    /**
     * 设置缓存
     * @access public
     * @param string $name 缓存名称
     * @param void $value 缓存数据
     * @param null|int $expire 缓存时间
     * @return bool
     */
    public function set($name, $value, $expire = null) {
        //缓存KEY
        $name = $this->options['prefix'] . $name;
        //删除缓存
        if (is_null($value)) {
            return $this->del($name);
        }
        //是否压缩数据
        // $zip = $this->options['zip'] ? Redis_COMPRESSED : 0;
        foreach ($this->RedisObj as $obj) {
            //设置缓存
            $data = $obj->set($name, $value);
            //设置过期时间
            $expire = is_null($expire) ? $this->options['expire'] : (int) $expire;
            if ($expire) {
                $obj->expire($name, $expire);
            }
        }
        //缓存计数
        if ($this->options['save'] === true) {
            if ($data === false) {
                N("hd_cache_set_misses", 1);
            } else {
                N("hd_cache_set_hits", 1);
            }
        }
        return $data;
    }

    /**
     * 获得缓存数据
     * @access public
     * @param string $name  缓存KEY
     * @return boolean
     */
    public function get($name,$ctime=null) {
        //缓存KEY
        $name = $this->options['prefix'] . $name;
        $objs = $this->RedisObj;
        for ($i = 0; $i < count($this->RedisObj); $i++) {
            $_index = array_rand($objs);
            $data = $objs[$_index]->get($name);
            if ($data !== false) {
                break;
            }
            unset($objs[$_index]);
        }
        return $data !== false ? $data : NULL;
    }

    /**
     * 删除缓存
     * @access public
     * @param type $name  缓存KEY
     * @return boolean
     */
    public function del($name) {
        //缓存KEY
        $name = $this->options['prefix'] . $name;
        foreach ($this->RedisObj as $obj) {
            $obj->del($name);
        }
        return true;
    }

    /**
     * 删除所有缓存数据
     * @return boolean
     */
    public function delAll() {
        return $this->RedisObj->flushall();
    }

}

?>
