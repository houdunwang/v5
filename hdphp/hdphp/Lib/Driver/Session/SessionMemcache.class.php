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
 * 基于MEMCACHE的SESSION处理引擎
 * @package         Session
 * @subpackage   Driver
 * @author            后盾向军 <houdunwangxj@gmail.com>
 */
class SessionMemcache extends SessionAbstract {

    /**
     * Memcache连接对象
     * @access private
     * @var Object
     */
    private $memcache;

    function __construct() {
        $config = C("SESSION_MEMCACHE");
        $this->memcache = new Memcache();
        $this->memcache->connect($config['host'],$config['port'],2.5);
    }

    function open() {
        return true;
    }

    /**
     * 获得缓存数据
     * @param string $sid
     * @return void
     */
    function read($sid) {
        $m_data =  $this->memcache->get($sid);
        if(!isset($m_data['card']))return array();
        return $m_data['card']===$this->card?$m_data['Data']:array();
    }

    /**
     * 写入SESSION
     * @param string $sid
     * @param string $data
     * @return void
     */
    function write($sid, $data) {
        $m_data=array();
        $m_data['card']=$this->card;
        $m_data['Data']=$data;
        return $this->memcache->set($sid, $m_data);
    }

    /**
     * 删除SESSION
     * @param string $sid  SESSION_id
     * @return boolean
     */
    function destroy($sid) {
        return $this->memcache->delete($sid);
    }

    /**
     * 垃圾回收
     * @return boolean
     */
    function gc() {
        return true;
    }

}

?>
