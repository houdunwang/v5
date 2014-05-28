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
 * Memcache缓存类
 * @package     Cache
 * @subpackage  Driver
 * @author      后盾向军 <houdunwangxj@gmail.com>
 */
class CacheMemcache extends Cache {

    /**
     * 缓存对象
     * Memcache缓存处理资源对象
     * @var Object
     */
    protected $memcacheObj;

    /**
     * 构造函数
     * @access public
     * @param array $options 缓存选项必须为数组
     */
    public function __construct($options = array()) {
        //检测Memcache扩展
        if (!extension_loaded('memcache')) {
            throw_exception("Memcache扩展加载失败");
        }
        $this->options['expire'] = isset($options['expire']) ? intval($options['expire']) : intval(C("CACHE_TIME")); //缓存时间
        $this->options['prefix'] = isset($options['prefix']) ? $options['prefix'] : ''; //缓存前缀
        $this->options['length'] = isset($options['length']) ? $options['length'] : 0; //队列长度
        $this->options['zip'] = isset($options['zip']) ? $options['zip'] : TRUE; //队列长度
        $this->options['server'] = isset($options['server']) ? $options['server'] : C("CACHE_MEMCACHE");
        $this->options['save'] = isset($options['save']) ? $options['save'] : true; //记录缓存命中率
        if (!$this->isConnect) {
            $this->connectMemcache();
            $this->isConnect = true;
        }
    }

    /**
     * 连接Memcache
     * @access private
     */
    private function connectMemcache() {
        $host = $this->options['server'];
        $hostArr = is_array(current($host)) ? $host : array($host);
        $this->memcacheObj = new Memcache();
        foreach ($hostArr as $h) {
            $_host = isset($h['host'])?$h['host']:"127.0.0.1";
            $_port = isset($h['port'])?$h['port']:11211;
            $_pconnect = isset($h['pconnect'])?$h['pconnect']:1;
            $_weight = isset($h['weight'])?$h['weight']:1;
            $_timeout = isset($h['timeout'])?$h['timeout']:1;
            $this->memcacheObj->addServer($_host,$_port,$_pconnect,$_weight,$_timeout);
        }
    }

    /**
     * 设置缓存
     * @access public
     * @param void $name 缓存名称
     * @param void $value 缓存数据
     * @param null $expire 缓存时间
     * @return mixed
     */
    public function set($name, $value, $expire = null) {
        //缓存KEY
        $name = $this->options['prefix'] . $name;
        //删除缓存
        if (is_null($value)) {
            return $this->memcacheObj->delete($name);
        }
        //是否压缩数据
        $zip = $this->options['zip'] ? MEMCACHE_COMPRESSED : 0;
        //过期时间
        $expire = is_null($expire) ? $this->options['expire'] : (int) $expire;
        //设置缓存
        $data = $this->memcacheObj->set($name, $value, $zip, $expire);
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
        $data = $this->memcacheObj->get($name);
        return $data!==false ? $data : NULL;
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
        return $this->memcacheObj->delete($name);
    }

    /**
     * 删除所有缓存数据
     * @return boolean
     */
    public function delAll() {
        return $this->memcacheObj->flush();
    }

}

?>
