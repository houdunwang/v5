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
class SessionMemcache
{

    /**
     * Memcache连接对象
     * @access private
     * @var Object
     */
    private $memcache;

    function __construct()
    {

    }

    public function run()
    {
        $options = C("SESSION_OPTIONS");
        $this->memcache = new Memcache();
        $this->memcache->connect($options['host'], $options['port'], 2.5);
        session_set_save_handler(
            array(&$this, "open"),
            array(&$this, "close"),
            array(&$this, "read"),
            array(&$this, "write"),
            array(&$this, "destroy"),
            array(&$this, "gc")
        );
    }

    public function open()
    {
        return true;
    }

    /**
     * 获得缓存数据
     * @param string $sid
     * @return boolean
     */
    public function read($sid)
    {
        return $this->memcache->get($sid);
    }

    /**
     * 写入SESSION
     * @param string $sid
     * @param string $data
     * @return mixed
     */
    public function write($sid, $data)
    {
        return $this->memcache->set($sid, $data);
    }

    /**
     * 删除SESSION
     * @param string $sid SESSION_id
     * @return boolean
     */
    public function destroy($sid)
    {
        return $this->memcache->delete($sid);
    }

    /**
     * 垃圾回收
     * @return boolean
     */
    public function gc()
    {
        return true;
    }

}

?>
